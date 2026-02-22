<?php
$kicker = get_field('about_kicker') ?: 'About Ascend Aesthetics';
$h1 = get_field('about_heading_line_1') ?: 'Where Precision';
$hGold = get_field('about_heading_gold') ?: 'Meets Provenance';

$p1 = get_field('about_paragraph_1') ?: 'Ascend Aesthetics was founded on a singular conviction: that research professionals
            deserve access to peptide compounds of unimpeachable quality, presented with the
            transparency and refinement befitting their work.';
$p2 = get_field('about_paragraph_2') ?: 'Inspired by the exacting standards of world-class laboratories, we partner with
            boutique manufacturing facilities operating under GMP-aligned protocols. Every compound
            is synthesised with precision, independently verified, and delivered in packaging
            engineered to preserve integrity.';
$p3 = get_field('about_paragraph_3') ?: 'We do not make therapeutic claims. We do not cut corners. We supply research-grade
            compounds to laboratories and institutions that accept nothing less than the
            highest standard of purity and documentation.';

$img = get_field('about_image') ?: '/assets/img/product-kit.png';
?>
<section id="about" class="py-32 marble-texture" data-animate="section">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div>
        <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-6 js-stagger" >
          <?php echo esc_html($kicker); ?>
        </p>
        <h2 class="font-display text-4xl md:text-5xl font-light text-foreground mb-8 leading-tight js-stagger">
          <?php echo esc_html($h1); ?><br />
          <span class="gold-text"><?php echo esc_html($hGold); ?></span>
        </h2>
        <div class="space-y-5 font-body text-sm text-muted-foreground leading-relaxed js-stagger">
          <p>
            <?php echo esc_html($p1); ?>
          </p>
          <p>
            <?php echo esc_html($p2); ?>
          </p>
          <p>
            <?php echo esc_html($p3); ?>
          </p>
        </div>
      </div>

      <div class="relative">
        <div class="aspect-square overflow-hidden">
         <?php if ($img) : ?>
        <img
            src="<?php echo esc_url($img); ?>"
            alt="Ascend Aesthetics premium peptide research kit"
            class="w-full h-full object-cover"
            loading="lazy"
          />
         <?php endif; ?>
        </div>
        <div class="absolute -bottom-4 -right-4 w-32 h-32 border border-primary/20"></div>
      </div>
    </div>
  </div>
</section>