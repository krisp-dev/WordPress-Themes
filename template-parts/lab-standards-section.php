<?php
// template-parts/lab-standards-section.php

// Section heading
$kicker = get_field('lab_kicker') ?: 'Laboratory Standards';
$heading_line_1 = get_field('lab_heading_line_1') ?: 'Uncompromising';
$heading_gold = get_field('lab_heading_gold') ?: 'Quality Protocols';
$description = get_field('lab_description') ?: "Our quality infrastructure is built to exceed the expectations of demanding research institutions.\nEvery process, from synthesis to shipment, is documented, verified, and optimised for compound integrity.";

// === Default Fallback Standards ===
$default_standards = [
  [
    'title' => 'GMP-Aligned Production',
    'desc'  => 'All compounds are synthesised in facilities that follow Good Manufacturing Practice protocols, ensuring consistency, traceability, and contamination-free processing.',
  ],
  [
    'title' => 'Third-Party Purity Testing',
    'desc'  => 'Independent laboratories conduct HPLC and mass spectrometry analysis on every production batch. Results are published in full on each product\'s Certificate of Analysis.',
  ],
  [
    'title' => 'Cold-Chain Storage',
    'desc'  => 'From synthesis to dispatch, compounds are stored under controlled-temperature conditions. Shipments use insulated, light-resistant packaging to preserve molecular integrity.',
  ],
  [
    'title' => 'Research-Use Compliance',
    'desc'  => 'All products are sold exclusively for laboratory research purposes. Labelling, documentation, and marketing are aligned with research-use-only requirements.',
  ],
];

// === Build Standards Array ===
$acf_standards = [];

for ($i = 1; $i <= 4; $i++) {
  $title = get_field("lab_standard_{$i}_title");
  $desc  = get_field("lab_standard_{$i}_desc");

  if ($title || $desc) {
    $acf_standards[] = [
      'title' => $title ?: '',
      'desc'  => $desc ?: '',
    ];
  }
}

// Use ACF standards if at least one exists, otherwise use defaults
$standards = !empty($acf_standards) ? $acf_standards : $default_standards;
?>

<section id="standards" class="py-32 bg-background" data-animate="section">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-20">
      <div>
        <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-6">
          <?php echo esc_html($kicker); ?>
        </p>
        <h2 class="font-display text-4xl md:text-5xl font-light text-foreground mb-8 leading-tight">
          <?php echo esc_html($heading_line_1); ?><br />
          <span class="gold-text"><?php echo esc_html($heading_gold); ?></span>
        </h2>
        <p class="font-body text-sm text-muted-foreground leading-relaxed">
          <?php echo nl2br($description); ?>
        </p>
      </div>

      <div class="space-y-0">
        <?php foreach ($standards as $i => $s): ?>
  <div class="py-6 border-b border-border group js-stagger">
    <div class="flex items-start gap-6">
      
      <span class="font-headline text-lg text-primary/30 mt-1 shrink-0">
        <?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?>
      </span>

      <div>
        <?php if (!empty($s['title'])): ?>
          <h3 class="font-display text-lg text-foreground mb-2 group-hover:text-primary transition-colors duration-300">
            <?php echo esc_html($s['title']); ?>
          </h3>
        <?php endif; ?>

        <?php if (!empty($s['desc'])): ?>
          <p class="font-body text-sm text-muted-foreground leading-relaxed">
            <?php echo esc_html($s['desc']); ?>
          </p>
        <?php endif; ?>
      </div>

    </div>
  </div>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</section>