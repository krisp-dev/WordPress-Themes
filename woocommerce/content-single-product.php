<?php
defined('ABSPATH') || exit;

global $product;
if (!$product) return;

// Pull attributes (your helper reads custom product attributes)
$purity = function_exists('ascend_attr') ? ascend_attr($product, 'Purity') : '';
$weight = function_exists('ascend_attr') ? ascend_attr($product, 'Net Weight') : '';

$cats = wc_get_product_category_list($product->get_id(), ', ');
$first_cat = '';
if ($cats) {
  $first_cat = wp_strip_all_tags($cats);
  $first_cat = explode(',', $first_cat)[0] ?? '';
  $first_cat = trim($first_cat);
}

$in_stock = $product->is_in_stock();

// Use main description
$desc = wp_strip_all_tags($product->get_description());
?>

<section class="pt-28 pb-24">
  <div class="container mx-auto px-6">

    <!-- Back to collection -->
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
       class="inline-flex items-center gap-3 font-body text-[10px] tracking-[0.3em] uppercase text-muted-foreground hover:text-primary transition-colors">
      <span aria-hidden="true">←</span>
      Back to collection
    </a>

    <div class="mt-10 grid lg:grid-cols-2 gap-12 items-start">

      <!-- LEFT: Image -->
      <div class="bg-card border border-border overflow-hidden">
        <div class="relative aspect-square">
          <?php
          echo $product->get_image('large', [
            'class' => $in_stock
              ? 'w-full h-full object-cover'
              : 'w-full h-full object-cover opacity-70 grayscale'
          ]);
          ?>

          <?php if ($purity): ?>
            <div class="absolute top-4 right-4 px-3 py-2 bg-background/80 backdrop-blur-sm border border-border">
              <span class="font-body text-[9px] tracking-[0.25em] uppercase text-primary">
                <?php echo esc_html('' . trim($purity) . ' PURE'); ?>
              </span>
            </div>
          <?php endif; ?>

          <?php if (!$in_stock): ?>
            <div class="absolute bottom-4 left-4 px-3 py-2 bg-background/80 backdrop-blur-sm border border-border">
              <span class="font-body text-[9px] tracking-[0.25em] uppercase text-muted-foreground">
                Out of stock
              </span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- RIGHT: Details -->
      <div>

        <?php if ($first_cat): ?>
          <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">
            <?php echo esc_html($first_cat); ?>
          </p>
        <?php endif; ?>

        <h1 class="font-headline text-5xl md:text-6xl tracking-[0.12em] text-foreground">
          <?php the_title(); ?>
        </h1>

        <?php if ($desc): ?>
          <p class="mt-5 font-body text-sm text-muted-foreground leading-relaxed max-w-xl">
            <?php echo esc_html($desc); ?>
          </p>
        <?php endif; ?>

        <!-- Cards -->
        <div class="mt-10 grid sm:grid-cols-2 gap-6">
          <div class="bg-card border border-border p-5">
            <p class="font-body text-[9px] tracking-[0.35em] uppercase text-muted-foreground mb-2">Purity</p>
            <p class="font-body text-sm tracking-[0.1em] text-primary">
              <?php echo esc_html($purity ? '≥' . trim($purity) : '—'); ?>
            </p>
          </div>

          <div class="bg-card border border-border p-5">
            <p class="font-body text-[9px] tracking-[0.35em] uppercase text-muted-foreground mb-2">Net Weight</p>
            <p class="font-body text-sm tracking-[0.1em] text-foreground font-medium">
              <?php echo esc_html($weight ?: '—'); ?>
            </p>
          </div>
        </div>

        <!-- Storage (can later become per-product field) -->
        <div class="mt-6 bg-card border border-border p-5">
          <p class="font-body text-[9px] tracking-[0.35em] uppercase text-muted-foreground mb-2">Storage</p>
          <p class="font-body text-sm text-muted-foreground">
            Store at −20°C. Reconstitute with bacteriostatic water. Once reconstituted, stable for 28 days at 4°C.
          </p>
        </div>

        <!-- Price + Qty row -->
        <div class="mt-10 flex items-center gap-6">
          <div class="font-display text-3xl text-primary">
            <?php echo wp_kses_post($product->get_price_html()); ?>
          </div>

          <?php if ($in_stock): ?>
            <div class="aa-qty">
              <button type="button" class="aa-qty-btn" data-qty-minus aria-label="Decrease quantity">−</button>
              <input class="aa-qty-input"
                     type="number"
                     value="1"
                     min="1"
                     max="<?php echo esc_attr($product->get_max_purchase_quantity()); ?>"
                     inputmode="numeric">
              <button type="button" class="aa-qty-btn" data-qty-plus aria-label="Increase quantity">+</button>
            </div>
          <?php endif; ?>
        </div>

        <!-- Add to cart -->
        <?php if ($in_stock): ?>
          <form class="cart mt-6"
                action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
                method="post">
            <input type="hidden" name="quantity" value="1" id="aa-qty-hidden">
            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">

            <button type="submit"
              class="w-full gold-gradient py-4 font-body font-medium text-[12px] tracking-[0.25em] uppercase text-primary-foreground hover:opacity-90 transition-opacity">
              Add to cart — <?php echo wp_strip_all_tags($product->get_price_html()); ?>
            </button>
          </form>
        <?php else: ?>
          <div class="mt-6 w-full text-center py-4 border border-border text-muted-foreground font-body text-[10px] tracking-[0.25em] uppercase opacity-70">
            Out of stock
          </div>
        <?php endif; ?>

        <!-- Disclaimers -->
        <div class="mt-8 pt-8 border-t border-border">
          <p class="font-body text-[8px] tracking-[0.25em] uppercase text-muted-foreground">
            For laboratory research use only.
          </p>
          <p class="mt-2 font-body text-[8px] tracking-[0.25em] uppercase text-muted-foreground opacity-80">
            Not for human consumption. Not for diagnostic or therapeutic use.
          </p>
        </div>

      </div>
    </div>
  </div>
</section>