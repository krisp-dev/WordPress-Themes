<?php
defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) return;
?>

<div class="bg-card border border-border p-8">
  <h2 class="font-headline text-lg tracking-[0.1em] text-foreground mb-6">
    <?php esc_html_e('Coupon Code', 'woocommerce'); ?>
  </h2>

  <form class="w-full" method="post">
    <div class="flex w-full gap-3">
      <input
        type="text"
        name="coupon_code"
        class="flex-1 w-full bg-background border border-border px-4 h-12 font-body text-sm text-foreground placeholder:text-muted-foreground focus:border-primary outline-none transition-colors"
        placeholder="<?php esc_attr_e('Enter code', 'woocommerce'); ?>"
        id="coupon_code"
        value=""
      />

      <button
        type="submit"
        class="h-12 px-8 font-body text-[10px] tracking-[0.2em] uppercase border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-all"
        name="apply_coupon"
        value="<?php esc_attr_e('Apply', 'woocommerce'); ?>"
      >
        <?php esc_html_e('Apply', 'woocommerce'); ?>
      </button>
    </div>

    <?php
      // Nonce for coupon applying
      wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce');

      // Hook Woo expects for coupon forms
      do_action('woocommerce_cart_coupon');
    ?>
  </form>

  <div class="mt-4">
    <?php wc_print_notices(); ?>
  </div>
</div>