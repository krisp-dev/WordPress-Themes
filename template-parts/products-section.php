<?php
// template-parts/products-section.php

if (!function_exists('wc_get_products')) return;

$kicker = get_field('products_kicker') ?: 'Research Compounds';
$heading = get_field('products_heading') ?: 'The Collection';
$view_all_label = get_field('products_viewall_label') ?: 'View All';

$shop_url = function_exists('wc_get_page_permalink')
  ? wc_get_page_permalink('shop')
  : home_url('/shop/');

$products = wc_get_products([
  'status' => 'publish',
  'limit' => 4,
  'orderby' => 'date',
  'order' => 'DESC',
]);

?>
<section id="products" class="py-32 bg-background" data-animate="section">
  <div class="container mx-auto px-6">
    <div class="text-center mb-20">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-4">
        <?php echo esc_html($kicker); ?>
      </p>
      <h2 class="font-display text-4xl md:text-5xl font-light text-foreground">
        <?php echo esc_html($heading); ?>
      </h2>

    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-px bg-border">
      <?php foreach ($products as $i => $product): ?>
        <?php
          /** @var WC_Product $product */
          $link = get_permalink($product->get_id());
          $img  = wp_get_attachment_image_url($product->get_image_id(), 'large');
          $img  = $img ?: wc_placeholder_img_src('large');

          // Try "Purity" attribute (pa_purity / purity). If missing, hide badge.
          $purity = '';
          if (function_exists('ascend_attr')) {
            $purity = ascend_attr($product, 'Purity');
            if (!$purity) $purity = ascend_attr($product, 'purity');
          } else {
            $purity = $product->get_attribute('pa_purity') ?: $product->get_attribute('purity');
          }

          // "Full name" line: use short description if available (matches Lovable’s second line vibe)
          $sub = wp_strip_all_tags($product->get_short_description());
        ?>
        <a href="<?php echo esc_url($link); ?>" class="bg-card p-8 group cursor-pointer hover:bg-secondary/50 transition-colors duration-500 block js-stagger">
          <div class="aspect-square mb-8 overflow-hidden bg-obsidian relative">
            <img
              src="<?php echo esc_url($img); ?>"
              alt="<?php echo esc_attr($product->get_name()); ?>"
              class="w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700"
              loading="lazy"
            />
            <?php if (!empty($purity)): ?>
              <div class="absolute top-3 right-3 px-2 py-1 bg-background/80 backdrop-blur-sm">
                <span class="font-body text-[9px] tracking-[0.2em] uppercase text-primary">
                  <?php echo esc_html($purity); ?>
                </span>
              </div>
            <?php endif; ?>
          </div>

          <p class="font-headline text-lg tracking-[0.1em] text-foreground mb-1">
            <?php echo esc_html($product->get_name()); ?>
          </p>

          <?php if (!empty($sub)): ?>
            <p class="font-body text-[10px] tracking-[0.1em] uppercase text-muted-foreground mb-4">
              <?php echo esc_html($sub); ?>
            </p>
          <?php else: ?>
            <p class="font-body text-[10px] tracking-[0.1em] uppercase text-muted-foreground mb-4">
              Research compound
            </p>
          <?php endif; ?>

          <div class="flex items-center justify-between">
            <span class="font-body text-sm text-primary"><?php echo wp_kses_post($product->get_price_html()); ?></span>
            <span class="font-body text-[9px] tracking-[0.1em] text-muted-foreground">
              <?php
                $weight = $product->get_weight();
                echo $weight ? esc_html($weight . ' ' . get_option('woocommerce_weight_unit')) : '';
              ?>
            </span>
          </div>

          <div class="mt-6 pt-4 border-t border-border">
            <p class="font-body text-[8px] tracking-[0.15em] uppercase text-muted-foreground opacity-60">
              For laboratory research use only
            </p>
          </div>
        </a>
      <?php endforeach; ?>  

    </div>

    <div class="mt-8 flex justify-center">
      <a
         href="<?php echo esc_url($shop_url); ?>"
         class="gold-gradient px-10 py-3.5 font-body text-xs tracking-[0.2em] uppercase text-primary-foreground hover:opacity-90 transition-opacity"
      >
      <?php echo esc_html($view_all_label); ?>
      </a>
   </div>
  </div>
</section>