<?php
// Theme supports
add_action('after_setup_theme', function () {
  add_theme_support('woocommerce');
});

// Disable WooCommerce default CSS so our Tailwind styles fully control layout
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Sort by most popular
add_filter('woocommerce_default_catalog_orderby', function () {
  return 'popularity';
});

// Enqueue styles/scripts
add_action('wp_enqueue_scripts', function () {
  $css_path = get_stylesheet_directory() . '/assets/css/app.css';
  $css_uri  = get_stylesheet_directory_uri() . '/assets/css/app.css';

  wp_enqueue_style(
    'ascend-aesthetics',
    $css_uri,
    [],
    file_exists($css_path) ? filemtime($css_path) : null
  );

  // GSAP
  wp_enqueue_script(
    'gsap',
    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
    [],
    null,
    true
  );

  wp_enqueue_script(
    'gsap-customease',
    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/CustomEase.min.js',
    ['gsap'],
    null,
    true
  );

  wp_enqueue_script(
    'gsap-scrolltrigger',
    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
    ['gsap'],
    null,
    true
  );

  // Theme JS (depends on GSAP)
  wp_enqueue_script(
    'ascend-aesthetics-js',
    get_stylesheet_directory_uri() . '/assets/js/app.js',
    ['gsap', 'gsap-customease', 'gsap-scrolltrigger'],
    '1.0',
    true
  );
});

// Sidebar for Woo blocks (Price slider / Status / Active Filters)
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

// Helper: fetch custom WC attribute by label (works for "Purity" + "Net Weight")
if (!function_exists('ascend_attr')) {
  function ascend_attr(WC_Product $product, $label) {
    $slug = sanitize_title($label);

    // Most common: stored as slug (purity, net-weight)
    $val = $product->get_attribute($slug);
    if (!empty($val)) return $val;

    // Fallback: stored with original label
    $val = $product->get_attribute($label);
    return !empty($val) ? $val : '';
  }
}

// Ensure cart fragments script is present (so mini cart updates without refresh)
add_action('wp_enqueue_scripts', function () {
  if (function_exists('WC')) {
    wp_enqueue_script('wc-cart-fragments');
  }
}, 20);

// Update cart count, subtotal, and mini cart HTML via AJAX fragments
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {

  // Cart count
  $count = 0;
  if (function_exists('WC') && WC()->cart) {
    $count = WC()->cart->get_cart_contents_count();
  }
  $fragments['span[data-cart-count]'] = '<span class="absolute -top-2 -right-2 text-[9px] bg-primary text-primary-foreground px-1.5 py-0.5 rounded-full" data-cart-count>'
    . esc_html($count)
    . '</span>';

  // Subtotal
  $subtotal = '';
  if (function_exists('WC') && WC()->cart) {
    $subtotal = WC()->cart->get_cart_subtotal();
  }
  $fragments['span[data-cart-subtotal]'] = '<span data-cart-subtotal>' . wp_kses_post($subtotal) . '</span>';

  // Mini cart contents
  ob_start();
  woocommerce_mini_cart();
  $mini_cart = ob_get_clean();

  $fragments['div[data-cart-items]'] = '<div class="p-6 overflow-y-auto h-[calc(100%-160px)]" data-cart-items>' . $mini_cart . '</div>';

  return $fragments;
});