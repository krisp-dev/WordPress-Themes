<?php
defined('ABSPATH') || exit;

if (!is_ajax()) do_action('woocommerce_review_order_before_payment'); ?>

<div id="payment" class="woocommerce-checkout-payment mt-8">
  <?php
    $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();

    if (!empty($available_gateways)) :
  ?>
    <div class="space-y-3 mb-6">
      <?php
        foreach ($available_gateways as $gateway) {
          wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
        }
      ?>
    </div>

    <div class="mt-8">
      <?php do_action('woocommerce_review_order_before_submit'); ?>

      <?php
        $order_button_text = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));
        echo '<button type="submit"
                class="w-full font-body text-xs tracking-[0.2em] uppercase py-4 bg-primary text-primary-foreground hover:bg-primary/90 transition-all"
                name="woocommerce_checkout_place_order"
                id="place_order"
                value="' . esc_attr($order_button_text) . '"
                data-value="' . esc_attr($order_button_text) . '">'
                . esc_html($order_button_text) .
             '</button>';
      ?>

      <?php do_action('woocommerce_review_order_after_submit'); ?>
    </div>

  <?php else : ?>

    <p class="font-body text-xs text-muted-foreground">
      <?php esc_html_e('No payment methods are available for your location.', 'woocommerce'); ?>
    </p>

  <?php endif; ?>

  <?php wc_get_template('checkout/terms.php'); ?>
</div>

<?php if (!is_ajax()) do_action('woocommerce_review_order_after_payment'); ?>