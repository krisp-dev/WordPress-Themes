<?php get_header(); ?>

<main class="min-h-screen pt-24 pb-20 flex items-center justify-center bg-muted">
  <div class="text-center px-6">
    <h1 class="mb-4 text-4xl font-bold text-foreground">404</h1>
    <p class="mb-4 text-xl text-muted-foreground">Oops! Page not found</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-primary underline hover:text-primary/90">
      Return to Home
    </a>
  </div>
</main>

<?php get_footer(); ?>