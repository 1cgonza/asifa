<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <title></title>
</head>
<body <?php body_class(); ?>>

  <header id="site-header">
    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
      <?php
        $logoImgID = get_theme_mod('header_logo');
        $logo = wp_get_attachment_image_src($logoImgID, 'full');
      ?>
      <img src="<?php echo $logo[0]; ?>" />
    </a>

    <nav id="main-nav" role="navigation">
      <?php
      wp_nav_menu(array(
        'container'      => false,
        'menu_class'     => 'nav top-nav cf',
        'theme_location' => 'main'
      ));
      ?>
    </nav>
  </header>

  <main id="main" class="site-main" role="main">