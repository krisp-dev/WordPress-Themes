<?php
defined('ABSPATH') || exit;

$checkout = WC()->checkout();

if (WC()->cart && WC()->cart->is_empty()) : ?>
  <div class="min-h-screen bg-background">
    <div class="pt-24 pb-20 flex items-center justify-center">
      <div class="text-center">
        <h1 class="font-display text-3xl text-foreground mb-4">Cart is Empty</h1>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="font-body text-xs tracking-[0.15em] uppercase text-primary hover:underline">
          ← Browse Collection
        </a>
      </div>
    </div>
  </div>
  <?php return; ?>
<?php endif; ?>

<div class="pb-20">
  <div class="container mx-auto px-6">

    <a href="javascript:history.back()" class="inline-flex items-center gap-2 font-body text-xs tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors mb-10">
      <span aria-hidden="true">←</span> Back
    </a>

    <div class="text-center mb-16">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-4">Secure Checkout</p>
      <h1 class="font-display text-4xl md:text-5xl font-light text-foreground">Complete Your Order</h1>
    </div>

    <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

    <form name="checkout"
          method="post"
          class="checkout woocommerce-checkout"
          action="<?php echo esc_url(wc_get_checkout_url()); ?>"
          enctype="multipart/form-data">

      <?php
        // Explicit nonce = avoids "unable to process your order" issues on custom templates
        wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce');
      ?>

      <div class="grid lg:grid-cols-5 gap-12">

        <!-- LEFT: Details -->
        <div class="lg:col-span-3 space-y-8">

          <?php
            $fields = $checkout->get_checkout_fields('billing');
          ?>

          <!-- Customer Details -->
          <div class="bg-card border border-border p-8">
            <h2 class="font-headline text-lg tracking-[0.1em] text-foreground mb-6">Customer Details</h2>

            <div class="grid sm:grid-cols-2 gap-4">
              <?php
                woocommerce_form_field('billing_first_name', $fields['billing_first_name'], $checkout->get_value('billing_first_name'));
                woocommerce_form_field('billing_last_name', $fields['billing_last_name'], $checkout->get_value('billing_last_name'));

                echo '<div class="sm:col-span-2">';
                woocommerce_form_field('billing_email', $fields['billing_email'], $checkout->get_value('billing_email'));
                echo '</div>';

                echo '<div class="sm:col-span-2">';
                woocommerce_form_field('billing_phone', $fields['billing_phone'], $checkout->get_value('billing_phone'));
                echo '</div>';
              ?>
            </div>
          </div>

          <!-- Shipping Address (using billing fields for a clean, 1:1 layout) -->
          <div class="bg-card border border-border p-8">
            <h2 class="font-headline text-lg tracking-[0.1em] text-foreground mb-6">Shipping Address</h2>

            <div class="space-y-4">
              <?php
                woocommerce_form_field('billing_address_1', $fields['billing_address_1'], $checkout->get_value('billing_address_1'));
                woocommerce_form_field('billing_address_2', $fields['billing_address_2'], $checkout->get_value('billing_address_2'));

                // Add breathing room above the suburb/state/postcode row
                echo '<div class="grid sm:grid-cols-3 gap-4 mt-4">';
                woocommerce_form_field('billing_city', $fields['billing_city'], $checkout->get_value('billing_city'));
                woocommerce_form_field('billing_state', $fields['billing_state'], $checkout->get_value('billing_state'));
                woocommerce_form_field('billing_postcode', $fields['billing_postcode'], $checkout->get_value('billing_postcode'));
                echo '</div>';

                woocommerce_form_field('billing_country', $fields['billing_country'], $checkout->get_value('billing_country'));
              ?>
            </div>
          </div>

          <!-- Coupon slot (rendered here via JS to avoid nested forms) -->
          <div data-coupon-slot></div>

          <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        </div>

        <!-- RIGHT: Order Summary + Payment -->
        <div class="lg:col-span-2">
          <div class="sticky top-24 bg-card border border-border p-8">
            <h2 class="font-headline text-lg tracking-[0.1em] text-foreground mb-6">Order Summary</h2>

            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
              <?php
                // Items + totals
                woocommerce_order_review();

                // Payment methods + Place order button
                wc_get_template('checkout/payment.php');
              ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>

            <p class="mt-4 font-body text-[7px] tracking-[0.15em] uppercase text-muted-foreground text-center opacity-50">
              For laboratory research use only. Not for human consumption.
            </p>
          </div>
        </div>

      </div>

    </form>

    <?php
      // IMPORTANT: Coupon form must NOT be nested inside the checkout form.
      if (wc_coupons_enabled()) :
    ?>
      <div data-coupon-source style="display:none;">
        <?php wc_get_template('checkout/form-coupon.php'); ?>
      </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
  </div>
</div>