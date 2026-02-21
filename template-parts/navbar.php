<?php
$home = esc_url(home_url('/'));
?>

<nav class="fixed top-0 left-0 right-0 z-50 bg-background/80 backdrop-blur-xl border-b border-border">
  <div class="container mx-auto flex items-center justify-between h-16 px-6">
    <!-- Brand -->
    <a href="<?php echo $home; ?>" class="flex items-center gap-2">
      <span class="font-headline text-2xl tracking-[0.2em] gold-text">ASCEND</span>
      <span class="font-body text-[10px] tracking-[0.3em] text-muted-foreground uppercase">Aesthetics</span>
    </a>

    <!-- Desktop nav -->
    <div class="hidden md:flex items-center gap-10">
      <a href="<?php echo esc_url(home_url('/#products')); ?>" class="font-body text-xs tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors duration-300">Compounds</a>
      <a href="<?php echo esc_url(home_url('/#standards')); ?>" class="font-body text-xs tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors duration-300">Standards</a>
      <a href="<?php echo esc_url(home_url('/#coa')); ?>" class="font-body text-xs tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors duration-300">Transparency</a>
      <a href="<?php echo esc_url(home_url('/#about')); ?>" class="font-body text-xs tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors duration-300">About</a>

      <!-- Shop button (gold outline) -->
      <a
        href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
        class="font-body text-xs tracking-[0.15em] uppercase px-5 py-2 border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-all duration-300"
      >
        Shop
      </a>

      <!-- Cart button -->
      <button
        type="button"
        data-cart-toggle
        class="relative text-foreground hover:text-primary transition-colors duration-300"
        aria-label="Open cart"
      >
        <svg xmlns="http://www.w3.org/2000/svg"
          width="20" height="20"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round">
          <circle cx="8" cy="21" r="1"/>
          <circle cx="19" cy="21" r="1"/>
          <path d="M2.05 2h2l2.6 13.59a2 2 0 0 0 2 1.41h9.72a2 2 0 0 0 2-1.64L23 6H6"/>
        </svg>

        <?php
        $count = 0;
        if (function_exists('WC') && WC()->cart) {
          $count = WC()->cart->get_cart_contents_count();
        }
        ?>
        <span class="absolute -top-2 -right-2 text-[9px] bg-primary text-primary-foreground px-1.5 py-0.5 rounded-full" data-cart-count>
          <?php echo esc_html($count); ?>
        </span>
      </button>
    </div>

    <!-- Mobile actions: Cart + Menu -->
    <div class="md:hidden flex items-center gap-4">
      <!-- Mobile Cart -->
      <button
        type="button"
        data-cart-toggle
        class="relative text-foreground hover:text-primary transition-colors duration-300"
        aria-label="Open cart"
      >
        <svg xmlns="http://www.w3.org/2000/svg"
          width="20" height="20"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round">
          <circle cx="8" cy="21" r="1"/>
          <circle cx="19" cy="21" r="1"/>
          <path d="M2.05 2h2l2.6 13.59a2 2 0 0 0 2 1.41h9.72a2 2 0 0 0 2-1.64L23 6H6"/>
        </svg>

        <?php
          $count = 0;
          if (function_exists('WC') && WC()->cart) {
            $count = WC()->cart->get_cart_contents_count();
          }
          ?>
          <span class="absolute -top-2 -right-2 text-[9px] bg-primary text-primary-foreground px-1.5 py-0.5 rounded-full" data-cart-count>
            <?php echo esc_html($count); ?>
        </span>
      </button>

      <!-- Mobile Menu Toggle -->
      <button
        class="text-foreground"
        type="button"
        aria-controls="mobile-nav"
        aria-expanded="false"
        data-mobile-toggle
        aria-label="Open menu"
      >
        <svg data-icon="menu" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
          viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 6h16"></path>
          <path d="M4 12h16"></path>
          <path d="M4 18h16"></path>
        </svg>

        <svg data-icon="close" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
          viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="M6 6 18 18"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu Panel -->
  <div
    id="mobile-nav"
    class="md:hidden bg-background border-b border-border overflow-hidden
           grid grid-rows-[0fr] opacity-0
           transition-[grid-template-rows,opacity] duration-300 ease-out"
    data-mobile-panel
    aria-hidden="true"
  >
    <div class="min-h-0">
      <div class="flex flex-col px-6 py-8 gap-6">
        <a href="<?php echo esc_url(home_url('/#products')); ?>" class="font-body text-sm tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors" data-mobile-link>Compounds</a>
        <a href="<?php echo esc_url(home_url('/#standards')); ?>" class="font-body text-sm tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors" data-mobile-link>Standards</a>
        <a href="<?php echo esc_url(home_url('/#coa')); ?>" class="font-body text-sm tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors" data-mobile-link>Transparency</a>
        <a href="<?php echo esc_url(home_url('/#about')); ?>" class="font-body text-sm tracking-[0.15em] uppercase text-muted-foreground hover:text-primary transition-colors" data-mobile-link>About</a>

        <a
          href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
          class="mt-4 font-body text-sm tracking-[0.15em] uppercase px-5 py-3 border border-primary text-primary text-center hover:bg-primary hover:text-primary-foreground transition-all duration-300"
          data-mobile-link
        >
          Shop
        </a>
      </div>
    </div>
  </div>

  <!-- Cart Overlay -->
  <div
    class="fixed inset-0 bg-black/60 backdrop-blur-[2px] opacity-0 pointer-events-none transition-opacity duration-300 z-[99]"
    data-cart-overlay
    aria-hidden="true"
  >
  </div>

  <!-- Cart Drawer -->
  <div
    class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-background border-l border-border transform translate-x-full transition-transform duration-300 z-[100]"
    data-cart-drawer
    aria-hidden="true"
  >
    <div class="flex items-center justify-between p-6 border-b border-border">
      <h2 class="font-display text-lg font-light">Your Cart</h2>
      <button data-cart-close class="text-muted-foreground hover:text-primary transition-colors" aria-label="Close cart">
        ✕
      </button>
    </div>

    <div class="p-6 overflow-y-auto h-[calc(100%-160px)]" data-cart-items>
      <?php woocommerce_mini_cart(); ?>
    </div>

    <div class="p-6 border-t border-border">
      <div class="flex justify-between text-sm mb-4">
        <span>Subtotal</span>
        <span data-cart-subtotal>
          <?php echo (function_exists('WC') && WC()->cart) ? wp_kses_post(WC()->cart->get_cart_subtotal()) : ''; ?>
        </span>
      </div>

      <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
         class="block text-center gold-gradient px-6 py-3 uppercase text-xs tracking-[0.2em] text-primary-foreground">
        Checkout
      </a>
    </div>
  </div>
</nav>