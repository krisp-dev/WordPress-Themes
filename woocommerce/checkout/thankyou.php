<?php
defined('ABSPATH') || exit;

$order_id = 0;
if (isset($order) && is_a($order, 'WC_Order')) {
  $order_id = $order->get_id();
}
?>
<div class="pt-24 pb-20 flex items-center justify-center min-h-[80vh]">
  <div class="text-center max-w-lg mx-auto px-6">
    <div class="mb-8">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-primary mx-auto">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <path d="M22 4 12 14.01l-3-3"></path>
      </svg>
    </div>

    <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-4">Order Confirmed</p>
    <h1 class="font-display text-4xl md:text-5xl font-light text-foreground mb-6">Thank You</h1>

    <p class="font-body text-sm text-muted-foreground leading-relaxed mb-4">
      Your order has been received and is being processed. A confirmation email with your order details and tracking information will be sent to you shortly.
    </p>

    <?php if ($order_id): ?>
      <p class="font-body text-xs text-muted-foreground mb-10">
        Order Reference: <span class="text-primary">AU-<?php echo esc_html($order->get_order_number()); ?></span>
      </p>
    <?php endif; ?>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a
        href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
        class="font-body text-[10px] tracking-[0.2em] uppercase px-8 py-3 border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-all"
      >
        Continue Browsing
      </a>
      <a
        href="<?php echo esc_url(home_url('/')); ?>"
        class="font-body text-[10px] tracking-[0.2em] uppercase px-8 py-3 border border-border text-muted-foreground hover:text-foreground hover:border-foreground transition-all"
      >
        Return Home
      </a>
    </div>

    <div class="mt-12 pt-8 border-t border-border">
      <p class="font-body text-[7px] tracking-[0.2em] uppercase text-muted-foreground opacity-50">
        All products are for laboratory research use only. Not for human consumption.
      </p>
    </div>
  </div>
</div>