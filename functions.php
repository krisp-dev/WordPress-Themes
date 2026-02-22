<?php
/**
 * Ascend Aesthetics Theme functions
 */

// ---------------------------
// Theme setup
// ---------------------------
add_action('after_setup_theme', function () {
  add_theme_support('woocommerce');
});

// Disable WooCommerce default CSS so Tailwind controls layout
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Default sort: popularity
add_filter('woocommerce_default_catalog_orderby', function () {
  return 'popularity';
});


// ---------------------------
// Enqueue assets
// ---------------------------
add_action('wp_enqueue_scripts', function () {

  // CSS (compiled Tailwind output)
  $css_path = get_stylesheet_directory() . '/assets/css/app.css';
  $css_uri  = get_stylesheet_directory_uri() . '/assets/css/app.css';

  wp_enqueue_style(
    'ascend-aesthetics',
    $css_uri,
    [],
    file_exists($css_path) ? filemtime($css_path) : null
  );

  // GSAP
  wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], null, true);
  wp_enqueue_script('gsap-customease', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/CustomEase.min.js', ['gsap'], null, true);
  wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], null, true);

  // Woo fragments script (needed for AJAX cart updates)
  if (function_exists('WC')) {
    wp_enqueue_script('wc-cart-fragments');
  }

  // Theme JS
  $js_path = get_stylesheet_directory() . '/assets/js/app.js';
  wp_enqueue_script(
    'ascend-aesthetics-js',
    get_stylesheet_directory_uri() . '/assets/js/app.js',
    ['gsap', 'gsap-customease', 'gsap-scrolltrigger'],
    file_exists($js_path) ? filemtime($js_path) : '1.0',
    true
  );

  // Pass ajax + nonce to JS
  wp_localize_script('ascend-aesthetics-js', 'AA_CART', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('aa_cart_nonce'),
  ]);
}, 20);


// ---------------------------
// Sidebar for shop filters (blocks/widgets)
// ---------------------------
add_action('widgets_init', function () {
  register_sidebar([
    'name'          => 'Shop Filters',
    'id'            => 'shop-filters',
    'before_widget' => '<div class="mb-10">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">',
    'after_title'   => '</h4>',
  ]);
});


// ---------------------------
// Helper: product attribute by label
// ---------------------------
if (!function_exists('ascend_attr')) {
  function ascend_attr(WC_Product $product, $label) {
    $slug = sanitize_title($label);

    // Try slug first
    $val = $product->get_attribute($slug);
    if (!empty($val)) return $val;

    // Fallback: original label
    $val = $product->get_attribute($label);
    return !empty($val) ? $val : '';
  }
}


// ---------------------------
// Remove "View cart" injection + simplify messages
// ---------------------------

// Optional: replace default add-to-cart message HTML
add_filter('wc_add_to_cart_message_html', function ($message, $products) {
  return '<span class="font-body text-xs tracking-[0.1em] text-muted-foreground">Added to cart.</span>';
}, 10, 2);

// Don’t redirect to cart after add to cart
add_filter('woocommerce_add_to_cart_redirect', function ($url) {
  return false;
});


// ---------------------------
// Fragments: update drawer + navbar UI
// ---------------------------
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
  if (!function_exists('WC') || !WC()->cart) return $fragments;

  // Kill Woo's injected "View cart" link (AJAX add-to-cart)
  if (isset($fragments['a.added_to_cart'])) {
    unset($fragments['a.added_to_cart']);
  }

  $count    = WC()->cart->get_cart_contents_count();
  $subtotal = WC()->cart->get_cart_subtotal();

  ob_start();
  woocommerce_mini_cart(); // uses your theme override mini-cart.php if present
  $mini_cart = ob_get_clean();

  // Navbar badge
  $fragments['span[data-cart-count]'] =
    '<span class="absolute -top-2 -right-2 text-[9px] bg-primary text-primary-foreground px-1.5 py-0.5 rounded-full" data-cart-count>' .
      esc_html($count) .
    '</span>';

  // Drawer title count "(n)"
  $fragments['span[data-cart-total]'] =
    '<span class="font-body text-[10px] tracking-[0.1em] text-muted-foreground" data-cart-total>(' .
      esc_html($count) .
    ')</span>';

  // Items HTML (ONLY the items area)
  $fragments['div[data-cart-items]'] =
    '<div class="flex-1 overflow-y-auto" data-cart-items>' . $mini_cart . '</div>';

  // Subtotal value only (matches your nested <span data-cart-subtotal>)
  $fragments['span[data-cart-subtotal]'] =
    '<span data-cart-subtotal>' . wp_kses_post($subtotal) . '</span>';

  return $fragments;
}, 50);


// ---------------------------
// AJAX: Update cart item qty (for +/- buttons)
// ---------------------------
add_action('wp_ajax_aa_update_cart_item', 'aa_update_cart_item');
add_action('wp_ajax_nopriv_aa_update_cart_item', 'aa_update_cart_item');

function aa_update_cart_item() {
  if (!function_exists('WC') || !WC()->cart) {
    wp_send_json_error(['message' => 'Woo not loaded'], 400);
  }

  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'aa_cart_nonce')) {
    wp_send_json_error(['message' => 'Bad nonce'], 403);
  }

  $key = isset($_POST['cart_item_key']) ? wc_clean(wp_unslash($_POST['cart_item_key'])) : '';
  $qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

  if (!$key) {
    wp_send_json_error(['message' => 'Invalid request'], 400);
  }

  $qty = max(0, $qty);

  if ($qty === 0) {
    WC()->cart->remove_cart_item($key);
  } else {
    WC()->cart->set_quantity($key, $qty, true);
  }

  WC()->cart->calculate_totals();

  ob_start();
wc_get_template('cart/mini-cart.php');
$mini_cart = ob_get_clean();

  wp_send_json_success([
    'count'    => WC()->cart->get_cart_contents_count(),
    'subtotal' => WC()->cart->get_cart_subtotal(),
    'mini'     => $mini_cart,
  ]);
}

// ---------------------------
// Checkout field styling (Tailwind classes)
// ---------------------------
add_filter('woocommerce_form_field_args', function ($args, $key, $value) {
  // Label styling
  $args['label_class'] = array_merge($args['label_class'] ?? [], [
    'font-body', 'text-[9px]', 'tracking-[0.2em]', 'uppercase', 'text-muted-foreground', 'mb-2', 'block',
  ]);

  // Input styling (text/select/textarea)
  $args['input_class'] = array_merge($args['input_class'] ?? [], [
    'w-full', 'bg-background', 'border', 'border-border', 'px-4', 'py-3',
    'font-body', 'text-sm', 'text-foreground',
    'focus:border-primary', 'outline-none', 'transition-colors',
  ]);

  // Wrapper spacing (Woo wraps fields in <p>)
  $args['class'] = array_merge($args['class'] ?? [], ['!mb-0']);

  return $args;
}, 10, 3);

// Remove default Woo coupon output (we render it manually inside our custom checkout template)
add_action('wp', function () {
  if (function_exists('is_checkout') && is_checkout()) {
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
  }
});

// Remove checkout privacy policy text
add_filter('woocommerce_checkout_privacy_policy_text', '__return_empty_string');
add_filter('woocommerce_get_privacy_policy_text', '__return_empty_string');

// Prevent Woo from outputting the payment section via default hooks
add_action('wp', function () {
  if (function_exists('is_checkout') && is_checkout()) {
    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
  }
});