<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class('bg-black text-white'); ?>>
<?php wp_body_open(); ?>

<?php
// Global navbar on every page
get_template_part('template-parts/navbar');
?>