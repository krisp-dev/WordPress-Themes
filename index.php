<?php
get_header();
?>

<main class="pt-24 pb-20">
  <div class="container mx-auto px-6">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('prose prose-invert max-w-none'); ?>>
          <h1 class="font-display text-4xl md:text-5xl font-light text-foreground mb-6">
            <?php the_title(); ?>
          </h1>

          <div class="font-body text-sm text-muted-foreground leading-relaxed">
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="text-center">
        <h1 class="font-display text-3xl text-foreground mb-3">Nothing found</h1>
        <p class="font-body text-sm text-muted-foreground">
          The page you’re looking for doesn’t exist.
        </p>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();