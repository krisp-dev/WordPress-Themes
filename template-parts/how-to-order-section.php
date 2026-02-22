<?php
// template-parts/how-to-order.php

// Icons
$icons = [
  'flask' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v7.5L5.5 20a2 2 0 0 0 1.7 3h9.6a2 2 0 0 0 1.7-3L14 9.5V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/></svg>',
  'shield' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z"/></svg>',
  'lock' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
  'truck' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3"/><path d="M14 17h3l4-4v-3h-7"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="17.5" cy="17.5" r="1.5"/></svg>',
];

// Header
$kicker  = get_field('howto_kicker') ?: 'ACQUISITION PROCESS';
$heading = get_field('howto_heading') ?: 'How to Order';

// Default steps
$default_steps = [
  [
    'icon' => 'flask',
    'title' => 'Select Compound',
    'desc' => 'Browse our collection of research-grade peptides. Each listing includes full purity data, molecular specifications, and batch documentation.',
  ],
  [
    'icon' => 'lock',
    'title' => 'Secure Checkout',
    'desc' => 'Complete your order through our encrypted checkout. Transactions are processed with bank-grade security protocols.',
  ],
  [
    'icon' => 'truck',
    'title' => 'Tracked Dispatch',
    'desc' => 'Your compound is packaged in temperature-controlled, light-resistant containers and shipped with full tracking to your facility.',
  ],
];

// Build ACF steps (switch to ACF only if at least one is filled)
$acf_steps = [];
for ($i = 1; $i <= 3; $i++) {
  $t  = get_field("howto_step_{$i}_title");
  $d  = get_field("howto_step_{$i}_desc");
  $ic = get_field("howto_step_{$i}_icon");

  if ($t || $d || $ic) {
    $ic = isset($icons[$ic]) ? $ic : '';

    $acf_steps[] = [
      'icon'  => $ic,
      'title' => $t ?: '',
      'desc'  => $d ?: '',
    ];
  }
}

$steps = !empty($acf_steps) ? $acf_steps : $default_steps;
?>

<section id="order" class="py-32 marble-texture" data-animate="section">
  <div class="container mx-auto px-6">
    <div class="text-center mb-20">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-4">
        <?php echo esc_html($kicker); ?>
      </p>
      <h2 class="font-display text-4xl md:text-5xl font-light text-foreground">
        <?php echo esc_html($heading); ?>
      </h2>
    </div>

    <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-12">
      <?php foreach ($steps as $i => $s): ?>
  <?php
    $step_num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    $icon_key = $s['icon'] ?? '';
    $icon_svg = isset($icons[$icon_key]) ? $icons[$icon_key] : '';
  ?>

  <div class="relative js-stagger">
    <div class="flex items-center gap-4 mb-6">
      <span class="font-headline text-4xl text-primary/20">
        <?php echo esc_html($step_num); ?>
      </span>
      <div class="h-px flex-1 bg-border"></div>
    </div>

    <?php if ($icon_svg): ?>
      <div class="mb-4 text-primary">
        <?php echo $icon_svg; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($s['title'])): ?>
      <h3 class="font-display text-xl font-light text-foreground mb-3">
        <?php echo esc_html($s['title']); ?>
      </h3>
    <?php endif; ?>

    <?php if (!empty($s['desc'])): ?>
      <p class="font-body text-sm text-muted-foreground leading-relaxed">
        <?php echo esc_html($s['desc']); ?>
      </p>
    <?php endif; ?>

  </div>
<?php endforeach; ?>
    </div>
  </div>
</section>