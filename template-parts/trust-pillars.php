<?php
// template-parts/trust-pillars.php

function ascend_icon_svg($name) {
  // match lucide: size=20, strokeWidth=1
  $common = 'width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"';
  if ($name === 'target') {
    return "<svg $common><circle cx='12' cy='12' r='8'/><circle cx='12' cy='12' r='3'/></svg>";
  }
  if ($name === 'eye') {
    return "<svg $common><path d='M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z'/><circle cx='12' cy='12' r='3'/></svg>";
  }
  // shield
  return "<svg $common><path d='M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z'/></svg>";
}

$defaults = [
  ['icon' => 'shield', 'title' => 'Purity', 'subtitle' => '≥99% Verified', 'description' => 'Every batch undergoes rigorous HPLC and mass spectrometry analysis, verified by independent third-party laboratories.'],
  ['icon' => 'target', 'title' => 'Precision', 'subtitle' => 'GMP-Aligned', 'description' => 'Manufactured in GMP-aligned facilities with exacting quality controls at every stage of synthesis and packaging.'],
  ['icon' => 'eye', 'title' => 'Transparency', 'subtitle' => 'Full COA Access', 'description' => 'Complete Certificate of Analysis available for every batch. Verify purity, identity, and composition before you order.'],
];

$items = [];
for ($i = 1; $i <= 3; $i++) {
  $items[] = [
    'icon' => get_field("pillar_{$i}_icon") ?: $defaults[$i-1]['icon'],
    'title' => get_field("pillar_{$i}_title") ?: $defaults[$i-1]['title'],
    'subtitle' => get_field("pillar_{$i}_subtitle") ?: $defaults[$i-1]['subtitle'],
    'description' => get_field("pillar_{$i}_description") ?: $defaults[$i-1]['description'],
  ];
}
?>

<section class="py-32 bg-background">
  <div class="container mx-auto px-6">
    <div class="grid md:grid-cols-3 gap-px bg-border">
      <?php foreach ($items as $idx => $it): ?>
        <div class="bg-background p-12 text-center group js-pillar">
          <div class="flex justify-center mb-6">
            <div class="w-12 h-12 border border-primary/30 flex items-center justify-center group-hover:border-primary transition-colors duration-500">
              <span class="text-primary">
                <?php echo ascend_icon_svg($it['icon']); ?>
              </span>
            </div>
          </div>

          <h3 class="font-display text-2xl font-light text-foreground mb-1">
            <?php echo esc_html($it['title']); ?>
          </h3>

          <p class="font-body text-[10px] tracking-[0.3em] uppercase text-primary mb-6">
            <?php echo esc_html($it['subtitle']); ?>
          </p>

          <p class="font-body text-sm text-muted-foreground leading-relaxed">
            <?php echo esc_html($it['description']); ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
