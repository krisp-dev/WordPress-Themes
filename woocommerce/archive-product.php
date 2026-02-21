<?php
defined('ABSPATH') || exit;

get_header();

function ascend_shop_url($args = []) {
  $base = wc_get_page_permalink('shop');
  $current = $_GET;

  foreach ($args as $k => $v) {
    if ($v === null || $v === '') {
      unset($current[$k]);
    } else {
      $current[$k] = $v;
    }
  }

  // Reset pagination if filters change
  if (isset($args['product_cat']) || isset($args['orderby'])) {
    unset($current['paged']);
  }

  return esc_url(add_query_arg($current, $base));
}

$selected_cat = isset($_GET['product_cat']) ? sanitize_text_field($_GET['product_cat']) : '';
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'popularity';

// Woo uses menu_order / price / price-desc.
// We treat empty as default.
if ($orderby === '') $orderby = 'popularity';

$cats = get_terms([
  'taxonomy' => 'product_cat',
  'hide_empty' => true,
]);
?>

<main class="pt-32 pb-24 bg-background text-foreground">
  <div class="container mx-auto px-6">

    <!-- Header -->
    <header class="mb-16 text-center">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-6 opacity-90">
        THE COLLECTION
      </p>
      <h1 class="font-display text-4xl md:text-5xl font-light text-foreground">
        Research Compounds
      </h1>
    </header>

    <?php if (function_exists('wc_print_notices')) wc_print_notices(); ?>

    <div class="grid md:grid-cols-[224px_1fr] gap-12 items-start">

      <!-- Sidebar (FilterContent + Woo blocks for Price/Status) -->
      <aside class="w-full md:w-auto">
        <div class="md:sticky md:top-32">

          <!-- Mobile filters toggle -->
          <div class="md:hidden mb-6">
            <button
              type="button"
              class="w-full flex items-center justify-between px-5 py-3 border border-primary text-primary font-body text-xs tracking-[0.2em] uppercase"
              data-shop-filters-toggle
              aria-expanded="false"
              aria-controls="mobile-shop-filters"
            >
              Filters
              <span class="text-primary" aria-hidden="true">+</span>
            </button>

            <div
              id="mobile-shop-filters"
              class="mt-4 bg-background border border-border overflow-hidden
                     grid grid-rows-[0fr] opacity-0
                     transition-[grid-template-rows,opacity] duration-300 ease-out"
              data-shop-filters-panel
              aria-hidden="true"
            >
              <div class="min-h-0">
                <div class="p-5 aa-filters space-y-10">

                  <!-- Category -->
                  <div>
                    <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">Category</p>
                    <div class="space-y-2">
                      <a href="<?php echo ascend_shop_url(['product_cat' => null]); ?>"
                         class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $selected_cat === '' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                        All Compounds
                      </a>
                      <?php foreach ($cats as $cat): ?>
                        <a href="<?php echo ascend_shop_url(['product_cat' => $cat->slug]); ?>"
                           class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $selected_cat === $cat->slug ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                          <?php echo esc_html($cat->name); ?>
                        </a>
                      <?php endforeach; ?>
                    </div>
                  </div>

                  <!-- Sort By -->
                  <div>
                    <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">Sort By</p>
                    <div class="space-y-2">
                      <a href="<?php echo ascend_shop_url(['orderby' => 'popularity']); ?>"
                         class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'popularity' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                        Default
                      </a>
                      <a href="<?php echo ascend_shop_url(['orderby' => 'price']); ?>"
                         class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'price' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                        Price: Low → High
                      </a>
                      <a href="<?php echo ascend_shop_url(['orderby' => 'price-desc']); ?>"
                         class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'price-desc' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                        Price: High → Low
                      </a>
                    </div>
                  </div>

                  <!-- Clear -->
                  <?php if ($selected_cat || ($orderby && $orderby !== 'popularity')): ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                       class="font-body text-[10px] tracking-[0.2em] uppercase text-destructive hover:underline">
                      Clear Filters
                    </a>
                  <?php endif; ?>
                  

                </div>
              </div>
            </div>
          </div>

          <!-- Desktop sidebar -->
          <div class="hidden md:block aa-filters space-y-10">

            <div>
              <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">Category</p>
              <div class="space-y-2">
                <a href="<?php echo ascend_shop_url(['product_cat' => null]); ?>"
                   class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $selected_cat === '' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                  All Compounds
                </a>
                <?php foreach ($cats as $cat): ?>
                  <a href="<?php echo ascend_shop_url(['product_cat' => $cat->slug]); ?>"
                     class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $selected_cat === $cat->slug ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                    <?php echo esc_html($cat->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>

            <div>
              <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-4">Sort By</p>
              <div class="space-y-2">
                <a href="<?php echo ascend_shop_url(['orderby' => 'popularity']); ?>"
                   class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'popularity' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                  Default
                </a>
                <a href="<?php echo ascend_shop_url(['orderby' => 'price']); ?>"
                   class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'price' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                  Price: Low → High
                </a>
                <a href="<?php echo ascend_shop_url(['orderby' => 'price-desc']); ?>"
                   class="block w-full text-left font-body text-xs tracking-wide py-2 px-3 transition-colors <?php echo $orderby === 'price-desc' ? 'text-primary bg-secondary/50' : 'text-muted-foreground hover:text-foreground'; ?>">
                  Price: High → Low
                </a>
              </div>
            </div>

            <?php if ($selected_cat || ($orderby && $orderby !== 'popularity')): ?>
              <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                 class="font-body text-[10px] tracking-[0.2em] uppercase text-destructive hover:underline">
                Clear Filters
              </a>
            <?php endif; ?>

          </div>
        </div>
      </aside>

      <!-- Products grid -->
      <section class="flex-1">
        <?php if (woocommerce_product_loop()) : ?>

          <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-px bg-border">
            <?php while (have_posts()) : the_post(); ?>
              <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
          </div>

          <?php
          // pagination style: square buttons
          $total = wc_get_loop_prop('total_pages');
          $current = max(1, wc_get_loop_prop('current_page'));
          if ($total > 1): ?>
            <div class="flex justify-center items-center gap-2 mt-12">
              <?php for ($p = 1; $p <= $total; $p++): ?>
                <a href="<?php echo esc_url(get_pagenum_link($p)); ?>"
                   class="w-10 h-10 font-body text-xs border transition-all duration-300 flex items-center justify-center <?php
                     echo ($p === $current)
                       ? 'border-primary text-primary bg-primary/10'
                       : 'border-border text-muted-foreground hover:border-primary hover:text-primary';
                   ?>">
                  <?php echo (int) $p; ?>
                </a>
              <?php endfor; ?>
            </div>
          <?php endif; ?>

        <?php else : ?>
          <div class="py-16 text-center">
            <p class="text-muted-foreground">No products found.</p>
          </div>
        <?php endif; ?>
      </section>

    </div>
  </div>
</main>

<?php get_footer(); ?>