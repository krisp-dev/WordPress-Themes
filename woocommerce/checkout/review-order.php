<?php
defined('ABSPATH') || exit;

if (!function_exists('WC') || !WC()->cart) return;

$cart = WC()->cart;
?>

<!-- Line items -->
<div class="space-y-4 mb-6">
  <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item):
  $product = $cart_item['data'];
  if (!$product || !$product->exists()) continue;

  $img = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');
  $img = $img ?: wc_placeholder_img_src('thumbnail');

  $qty = (int) $cart_item['quantity'];

  // IMPORTANT: use Woo helper for consistent line totals (pre-discount)
  $line_display = WC()->cart->get_product_subtotal($product, $qty);
?>
  <div class="flex items-center gap-3">
    <div class="w-12 h-12 bg-obsidian flex-shrink-0 overflow-hidden">
      <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="w-full h-full object-cover opacity-60" />
    </div>
    <div class="flex-1 min-w-0">
      <p class="font-body text-xs text-foreground">
        <?php echo esc_html($product->get_name()); ?>
        <span class="text-muted-foreground">×<?php echo esc_html($qty); ?></span>
      </p>
    </div>
    <p class="font-body text-xs text-primary">
      <?php echo wp_kses_post($line_display); ?>
    </p>
  </div>
<?php endforeach; ?>
</div>

<!-- Totals -->
<div class="border-t border-border pt-4 space-y-3">

  <!-- Subtotal -->
  <div class="flex justify-between font-body text-xs text-muted-foreground">
    <span><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
    <span><?php echo wp_kses_post($cart->get_cart_subtotal()); ?></span>
  </div>

  <!-- Coupons / Discounts -->
  <?php if ($cart->get_coupons()): ?>
  <?php foreach ($cart->get_coupons() as $code => $coupon): ?>
    <div class="flex justify-between font-body text-xs text-muted-foreground">
      <span>
        <?php echo esc_html__('Coupon', 'woocommerce') . ': ' . esc_html(wc_strtoupper($code)); ?>
      </span>

      <span class="text-primary flex items-center gap-2">
        <?php
          // Discount amount (negative formatted)
          echo wp_kses_post(wc_price(-1 * $cart->get_coupon_discount_amount($code, $cart->display_prices_including_tax())));
        ?>

        <?php
          // Build a checkout-safe remove URL
          $remove_url = add_query_arg(
            ['remove_coupon' => rawurlencode($code)],
            wc_get_checkout_url()
          );

          // Preserve nonce if Woo expects it (safe to include)
          $remove_url = wp_nonce_url($remove_url, 'woocommerce-remove-coupon');
        ?>

        <a class="text-muted-foreground hover:text-primary underline"
           href="<?php echo esc_url($remove_url); ?>">
          <?php esc_html_e('Remove', 'woocommerce'); ?>
        </a>
      </span>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

  <!-- Fees (if you ever add any) -->
  <?php if ($cart->get_fees()): ?>
    <?php foreach ($cart->get_fees() as $fee): ?>
      <div class="flex justify-between font-body text-xs text-muted-foreground">
        <span><?php echo esc_html($fee->name); ?></span>
        <span><?php echo wp_kses_post(wc_price($fee->amount + $fee->tax)); ?></span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- Shipping -->
  <div class="flex justify-between font-body text-xs text-muted-foreground">
    <span><?php esc_html_e('Shipping', 'woocommerce'); ?></span>
    <span>
      <?php
        // Use Woo output so it stays correct (free shipping, methods, etc)
        if ($cart->needs_shipping() && $cart->show_shipping()) {
          ob_start();
          wc_cart_totals_shipping_html();
          $shipping_html = trim(ob_get_clean());

          // Strip wrapper tags to keep your UI clean, but preserve content
          echo wp_kses_post($shipping_html ?: wc_price(0));
        } else {
          // fallback
          $shipping_total = (float) $cart->get_shipping_total() + (float) $cart->get_shipping_tax();
          echo wp_kses_post(wc_price($shipping_total));
        }
      ?>
    </span>
  </div>

  <!-- Taxes (only if enabled & displayed) -->
  <?php if (wc_tax_enabled() && ! $cart->display_prices_including_tax()): ?>
    <?php if ('itemized' === get_option('woocommerce_tax_total_display')): ?>
      <?php foreach ($cart->get_tax_totals() as $code => $tax): ?>
        <div class="flex justify-between font-body text-xs text-muted-foreground">
          <span><?php echo esc_html($tax->label); ?></span>
          <span><?php echo wp_kses_post($tax->formatted_amount); ?></span>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="flex justify-between font-body text-xs text-muted-foreground">
        <span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
        <span><?php echo wp_kses_post(wc_price($cart->get_taxes_total())); ?></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Total -->
  <div class="flex justify-between font-body text-sm text-foreground pt-3 border-t border-border">
    <span class="tracking-[0.1em] uppercase"><?php esc_html_e('Total', 'woocommerce'); ?></span>
    <span class="font-display text-xl text-primary"><?php echo wp_kses_post($cart->get_total()); ?></span>
  </div>

</div>