<?php
defined('ABSPATH') || exit;

global $product;
if (empty($product) || !$product->is_visible()) return;

$purity = ascend_attr($product, 'Purity');
$weight = ascend_attr($product, 'Net Weight');

$short = wp_strip_all_tags($product->get_short_description());
$short = $short ? $short : '';

$cats = wc_get_product_category_list($product->get_id(), ', ');
$first_cat = '';
if ($cats) {
  $first_cat = wp_strip_all_tags($cats);
  $first_cat = explode(',', $first_cat)[0] ?? '';
  $first_cat = trim($first_cat);
}

$in_stock = $product->is_in_stock();
?>

<div <?php wc_product_class('bg-card group', $product); ?>>

  <a href="<?php the_permalink(); ?>" class="block">
    <div class="aspect-square overflow-hidden bg-obsidian relative">

  <?php
  $image_classes = $in_stock
    ? 'w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700'
    : 'w-full h-full object-cover opacity-40 grayscale transition-all duration-500';
  ?>

  <?php echo $product->get_image('woocommerce_thumbnail', [
    'class' => $image_classes
  ]); ?>

  <?php if ($purity): ?>
    <div class="absolute top-3 right-3 px-2 py-1 bg-background/80 backdrop-blur-sm">
      <span class="font-body text-[9px] tracking-[0.2em] uppercase text-primary">
        <?php echo esc_html($purity); ?>
      </span>
    </div>
  <?php endif; ?>

  <?php if (!$in_stock): ?>
    <div class="absolute inset-0 bg-background/20"></div>

    <div class="absolute bottom-3 left-3 px-2 py-1 bg-background/80 backdrop-blur-sm border border-border">
      <span class="font-body text-[9px] tracking-[0.2em] uppercase text-muted-foreground">
        Out of stock
      </span>
    </div>
  <?php endif; ?>

</div>
  </a>

  <div class="p-6">
    <a href="<?php the_permalink(); ?>">
      <p class="font-headline text-lg tracking-[0.1em] text-foreground mb-1"><?php the_title(); ?></p>

      <?php if ($short): ?>
        <p class="font-body text-[10px] tracking-[0.1em] uppercase text-muted-foreground mb-1">
          <?php echo esc_html($short); ?>
        </p>
      <?php endif; ?>
    </a>

    <?php if ($first_cat): ?>
      <p class="font-body text-[9px] tracking-[0.15em] uppercase text-primary/70 mb-4">
        <?php echo esc_html($first_cat); ?>
      </p>
    <?php endif; ?>

    <div class="flex items-center justify-between mb-4">
      <span class="font-body text-sm text-primary">
        <?php echo wp_kses_post($product->get_price_html()); ?>
      </span>

      <?php if ($weight): ?>
        <span class="font-body text-[9px] tracking-[0.1em] text-muted-foreground">
          <?php echo esc_html($weight); ?>
        </span>
      <?php endif; ?>
    </div>

    <?php if ($in_stock): ?>

      <?php
      // Add to Cart (full-width outline)
      echo apply_filters(
        'woocommerce_loop_add_to_cart_link',
        sprintf(
          '<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
          esc_url($product->add_to_cart_url()),
          esc_attr('w-full block text-center font-body text-[12px] tracking-[0.2em] uppercase py-2.5 border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-all duration-300 add_to_cart_button ajax_add_to_cart'),
          wc_implode_html_attributes([
            'data-product_id' => $product->get_id(),
            'data-product_sku' => $product->get_sku(),
            'aria-label'       => $product->add_to_cart_description(),
            'rel'              => 'nofollow',
          ]),
          esc_html($product->add_to_cart_text())
        ),
        $product
      );
      ?>

    <?php else: ?>

      <div class="w-full block text-center font-body text-[12px] tracking-[0.2em] uppercase py-2.5 border border-border text-muted-foreground opacity-60 cursor-not-allowed">
        Out of stock
      </div>

    <?php endif; ?>

    <p class="mt-3 font-body text-[7px] tracking-[0.15em] uppercase text-muted-foreground opacity-50 text-center">
      For laboratory research use only
    </p>
  </div>
</div>