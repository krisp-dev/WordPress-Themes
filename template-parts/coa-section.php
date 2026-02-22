<?php
// template-parts/coa-section.php


// Icons 
$icons = [
  'file' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
  'hash' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg>',
  'search' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
  'download' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>',
];

// Header content
$kicker = get_field('coa_kicker') ?: 'FULL TRANSPARENCY';
$heading = get_field('coa_heading') ?: 'Certificate of Analysis';
$subheading = get_field('coa_subheading') ?: 'We believe transparency is non-negotiable. Every compound we supply is accompanied by comprehensive analytical documentation.';

// Left image
$coa_image = get_field('coa_image');
if (!$coa_image) {
  $coa_image = get_stylesheet_directory_uri() . '/assets/img/coa-flatlay.png';
}

// Default features
$default_features = [
  [
    'icon'  => 'file',
    'title' => 'Certificate of Analysis',
    'desc'  => 'Each COA details compound identity, purity percentage via HPLC, residual solvent analysis, and endotoxin levels—verified by accredited third-party laboratories.',
  ],
  [
    'icon'  => 'hash',
    'title' => 'Batch Identification',
    'desc'  => 'Every production run is assigned a unique alphanumeric batch code. This code links to the compound\'s full analytical record in our verification system.',
  ],
  [
    'icon'  => 'search',
    'title' => 'Independent Verification',
    'desc'  => 'Researchers can validate any batch by entering its code in a verification portal. Instant access to the complete COA with downloadable documentation.',
  ],
  [
    'icon'  => 'download',
    'title' => 'Downloadable Reports',
    'desc'  => 'Full COA documents are available in PDF format. Each report includes laboratory name, methodology, acceptance criteria, and analyst signatures.',
  ],
];

// Build ACF features (only switch if at least one field is filled)
$acf_features = [];
for ($i = 1; $i <= 4; $i++) {
  $t  = get_field("coa_feature_{$i}_title");
  $d  = get_field("coa_feature_{$i}_desc");
  $ic = get_field("coa_feature_{$i}_icon");

  if ($t || $d || $ic) {
    // validate icon key
    $ic = isset($icons[$ic]) ? $ic : '';

    $acf_features[] = [
      'icon'  => $ic,
      'title' => $t ?: '',
      'desc'  => $d ?: '',
    ];
  }
}

$features = !empty($acf_features) ? $acf_features : $default_features;
?>

<section id="coa" class="py-32 marble-texture" data-animate="section">
  <div class="container mx-auto px-6">
    <div class="text-center mb-20">
      <p class="font-body text-[10px] tracking-[0.5em] uppercase text-primary mb-4">
        <?php echo esc_html($kicker); ?>
      </p>
      <h2 class="font-display text-4xl md:text-5xl font-light text-foreground mb-6">
        <?php echo esc_html($heading); ?>
      </h2>
      <p class="font-body text-sm text-muted-foreground max-w-xl mx-auto">
        <?php echo esc_html($subheading); ?>
      </p>
    </div>

    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <img
          src="<?php echo esc_url($coa_image); ?>"
          alt="Certificate of Analysis with peptide vial"
          class="w-full aspect-square object-cover"
          loading="lazy"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-background/60 to-transparent"></div>
      </div>

      <div class="grid sm:grid-cols-2 gap-8">
        <?php foreach ($features as $f): ?>
  <div class="group js-stagger">

    <?php
      $icon_key = $f['icon'] ?? '';
      $icon_svg = isset($icons[$icon_key]) ? $icons[$icon_key] : '';
    ?>

    <?php if ($icon_svg): ?>
      <div class="text-primary mb-4">
        <?php echo $icon_svg; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($f['title'])): ?>
      <h3 class="font-display text-lg text-foreground mb-2">
        <?php echo esc_html($f['title']); ?>
      </h3>
    <?php endif; ?>

    <?php if (!empty($f['desc'])): ?>
      <p class="font-body text-xs text-muted-foreground leading-relaxed">
        <?php echo esc_html($f['desc']); ?>
      </p>
    <?php endif; ?>

  </div>
<?php endforeach; ?>
      </div>
    </div>

    
  </div>
</section>