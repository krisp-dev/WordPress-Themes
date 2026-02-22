<?php
defined('ABSPATH') || exit;

if (!function_exists('WC') || !WC()->cart) return;

$items = WC()->cart->get_cart();
?>

<?php if (empty($items)) : ?>
  <div class="flex flex-col items-center justify-center h-full text-center px-6">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
      class="text-muted-foreground/30 mb-4">
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
      <path d="M3 6h18"></path>
      <path d="M16 10a4 4 0 0 1-8 0"></path>
    </svg>

    <p class="font-body text-sm text-muted-foreground mb-6">Your cart is empty</p>

    <a
      href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
      class="font-body text-[10px] tracking-[0.2em] uppercase px-6 py-2.5 border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-all"
    >
      Browse Collection
    </a>
  </div>
<?php else : ?>
  <div class="divide-y divide-border">
    <?php foreach ($items as $cart_item_key => $cart_item) :
      $product = $cart_item['data'];
      if (!$product || !$product->exists()) continue;

      $name = $product->get_name();
      $qty  = (int) $cart_item['quantity'];
      $line_total = $cart_item['line_total'] ?? 0;

      $img = $product->get_image_id()
        ? wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail')
        : '';

      $weight = function_exists('ascend_attr') ? ascend_attr($product, 'Net Weight') : '';
    ?>
      <div class="p-6 flex gap-4" data-cart-row data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
        <div class="w-20 h-20 bg-obsidian flex-shrink-0 overflow-hidden">
          <?php if ($img) : ?>
            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" class="w-full h-full object-cover opacity-60" />
          <?php endif; ?>
        </div>

        <div class="flex-1 min-w-0">
          <p class="font-headline text-sm tracking-[0.1em] text-foreground"><?php echo esc_html($name); ?></p>

          <?php if (!empty($weight)) : ?>
            <p class="font-body text-[9px] tracking-[0.1em] uppercase text-muted-foreground mb-2">
              <?php echo esc_html($weight); ?>
            </p>
          <?php endif; ?>

          <div class="flex items-center gap-3">
            <div class="flex items-center border border-border">
              <button type="button" class="p-1.5 text-muted-foreground hover:text-foreground" data-cart-qty-minus aria-label="Decrease quantity">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14"></path>
                </svg>
              </button>

              <span class="px-2 font-body text-xs text-foreground" data-cart-qty><?php echo esc_html($qty); ?></span>

              <button type="button" class="p-1.5 text-muted-foreground hover:text-foreground" data-cart-qty-plus aria-label="Increase quantity">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 5v14"></path><path d="M5 12h14"></path>
                </svg>
              </button>
            </div>

            <button type="button" class="font-body text-[9px] uppercase text-primary/70 hover:text-primary hover:underline transition-colors" data-cart-remove>
              Remove
            </button>
          </div>
        </div>

        <p class="font-body text-sm text-primary" data-cart-line>
          <?php echo wp_kses_post(wc_price($line_total)); ?>
        </p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>