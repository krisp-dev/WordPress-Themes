<?php
// template-parts/hero.php

// Assumes ACF is active. If a field is empty, we fall back to the original Lovable text.
$kicker = get_field('hero_kicker') ?: 'Precision · Purity · Provenance';
$heading_gold = get_field('hero_heading_gold') ?: 'Research-Grade';
$heading_main = get_field('hero_heading_main') ?: 'Peptide Compounds';
$body = get_field('hero_body') ?: 'Uncompromising purity. Third-party verified. Engineered for laboratories that demand the absolute highest standard in research compounds.';
$disclaimer = get_field('hero_disclaimer') ?: 'For laboratory research use only · Not for human consumption';

$bg_img = get_field('hero_background_image'); // Return format: URL
$hero_img = $bg_img ?: (get_stylesheet_directory_uri() . '/assets/img/hero-vial.jpg');

// Link fields (ACF Link returns array: ['url','title','target'])
$cta1 = get_field('hero_primary_cta_link');
$cta1_href = is_array($cta1) && !empty($cta1['url']) ? $cta1['url'] : '#products';
$cta1_target = is_array($cta1) && !empty($cta1['target']) ? $cta1['target'] : '_self';
$cta1_label = get_field('hero_primary_cta_label') ?: 'Explore Compounds';

$cta2 = get_field('hero_secondary_cta_link');
$cta2_href = is_array($cta2) && !empty($cta2['url']) ? $cta2['url'] : '#coa';
$cta2_target = is_array($cta2) && !empty($cta2['target']) ? $cta2['target'] : '_self';
$cta2_label = get_field('hero_secondary_cta_label') ?: 'View Lab Reports';
?>

<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
  <!-- Background image -->
  <div class="absolute inset-0">
    <img
      src="<?php echo esc_url($hero_img); ?>"
      alt="Luxury peptide vial on black marble"
      class="w-full h-full object-cover opacity-40"
      loading="eager"
      fetchpriority="high"
    />
    <div class="absolute inset-0 bg-gradient-to-b from-background via-background/60 to-background"></div>
  </div>

  <div class="relative z-10 container mx-auto px-6 text-center">
    <div class="max-w-4xl mx-auto js-hero">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-8">
        <?php echo esc_html($kicker); ?>
      </p>

      <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-light leading-[0.95] mb-8">
        <span class="gold-text"><?php echo esc_html($heading_gold); ?></span>
        <br />
        <span class="text-foreground"><?php echo esc_html($heading_main); ?></span>
      </h1>

      <p class="font-body text-sm md:text-base text-muted-foreground max-w-xl mx-auto mb-12 leading-relaxed">
        <?php echo esc_html($body); ?>
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a
          href="<?php echo esc_url($cta1_href); ?>"
          target="<?php echo esc_attr($cta1_target); ?>"
          rel="<?php echo $cta1_target === '_blank' ? 'noopener noreferrer' : 'nofollow'; ?>"
          class="gold-gradient px-10 py-3.5 font-body text-xs tracking-[0.2em] uppercase text-primary-foreground hover:opacity-90 transition-opacity"
        >
          <?php echo esc_html($cta1_label); ?>
        </a>

        <a
          href="<?php echo esc_url($cta2_href); ?>"
          target="<?php echo esc_attr($cta2_target); ?>"
          rel="<?php echo $cta2_target === '_blank' ? 'noopener noreferrer' : 'nofollow'; ?>"
          class="px-10 py-3.5 font-body text-xs tracking-[0.2em] uppercase border border-border text-foreground hover:border-primary hover:text-primary transition-all duration-300"
        >
          <?php echo esc_html($cta2_label); ?>
        </a>
      </div>

      <p class="font-body text-[9px] tracking-[0.2em] uppercase text-muted-foreground mt-16 opacity-50">
        <?php echo esc_html($disclaimer); ?>
      </p>
    </div>
  </div>
</section>
