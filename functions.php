<?php

include 'utils/custom-post-types.php';
include 'utils/meta-boxes.php';
include 'utils/equipo.php';

function asifa_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');
  set_post_thumbnail_size(1200, 9999);
  add_theme_support('html5', array(
    'comment-form',
    'comment-list',
    'search-form',
    'gallery',
    'caption'
  ));
  add_editor_style( array( 'css/editor-style.min.css', asifa_google_fonts() ) );

  register_nav_menus( array(
    'main' => 'Men&uacute; Principal'
  ) );

  add_image_size('asifa-500x500', 500, 500, array('center', 'center'));
  add_image_size('asifa-150xauto', 150, 9999);
  add_image_size('asifa-2000xauto', 2000, 9999);
}
add_action('after_setup_theme', 'asifa_setup');

function asifa_google_fonts() {
  $url = '';
  $fonts = array();
  $fonts[] = 'Inconsolata:400,700';

  if ( !empty($fonts) ) {
    $url = add_query_arg('family', urldecode( implode('|', $fonts) ), 'https://fonts.googleapis.com/css');
  }
  return $url;
}

function check_for_js() {
  echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'check_for_js', 0);

function asifa_scripts() {
  wp_enqueue_style('asifa-fonts', asifa_google_fonts(), array(), null);
  wp_enqueue_style('asifa-style', get_template_directory_uri() . '/css/style.min.css', array(), '');
  wp_enqueue_script('asifa-script', get_template_directory_uri() . '/js/scripts.min.js', array( 'jquery' ), '', true);
}
add_action( 'wp_enqueue_scripts', 'asifa_scripts' );

function asifa_archive_title( $title ) {
  if ( is_category() ) {
      $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
      $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
      $title = '<span class="vcard">' . get_the_author() . '</span>';
  } elseif ( is_post_type_archive() ) {
      $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
      $title = single_term_title( '', false );
  }
  return $title;
}
add_filter( 'get_the_archive_title', 'asifa_archive_title' );

/*===========================================
=            Quitar basura de WP            =
===========================================*/
// Emojis
function disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins) {
  if ( is_array($plugins) ) {
    return array_diff( $plugins, array('wpemoji') );
  } else {
    return array();
  }
}

/*=====  End of Quitar basura de WP  ======*/

/*================================
=            Sidebars            =
================================*/
function asifa_sidebars() {
  $args = array(
    'id'    => 'sidebar-home',
    'class' => 'asifa-sidebar bg-highlight-2 m-all t-1of4 d-1of4 ld-1of4',
    'name'  => 'Home Sidebar',
    'description' => 'Muestra la informaci&oacute;n de registro y el feed de Facebook',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
  );
  register_sidebar( $args );

  $args = array(
    'id'          => 'sidebar-general',
    'class'       => 'asifa-sidebar',
    'name'        => 'Sidebar general',
    'description' => 'Muestra el feed de Facebook',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',

  );
  register_sidebar( $args );
}
add_action( 'widgets_init', 'asifa_sidebars' );
/*=====  End of Sidebars  ======*/

/*=====================================
=            WP Customizer            =
=====================================*/
/**
* Una clase para ayudar a crear las diferentes opciones de wp_customize
*/
class AsifaCustomizerSetting {
  function __construct($wp_customize, $options) {
    if (empty($options) && sizeof($options) < 4) {
      return false;
    }

    $this->customize = $wp_customize;
    $this->section   = $options['section']  ? $options['section']  : NULL;
    $this->id        = $options['id']       ? $options['id']       : NULL;
    $this->label     = $options['label']    ? $options['label']    : NULL;
    $this->type      = $options['type']     ? $options['type']     : NULL;

    $wp_customize->add_setting($this->id);
    $control = $this->getControl();
    $wp_customize->add_control($control);
  }

  private function getControl() {
    if ( is_null($this->type) || $this->type == 'text') {
      return $this->getTextControl();
    } elseif ($this->type == 'media') {
      return $this->getMediaControl();
    }
  }

  private function getTextControl() {
    return new WP_Customize_Control($this->customize, $this->id,
      array(
        'label'    => $this->label,
        'section'  => $this->section,
        'settings' => $this->id,
        'type'     => 'text'
      )
    );
  }

  private function getMediaControl() {
    return new WP_Customize_Media_Control($this->customize, $this->id,
      array(
        'label'     => $this->label,
        'section'   => 'media',
        'mime_type' => 'image',
        'section'   => $this->section,
        'settings'  => $this->id
      )
    );
  }
}

function ka_customize_register($wp_customize) {
  /*----------  Site assets  ----------*/
  new AsifaCustomizerSetting($wp_customize, array(
    'section' => 'title_tagline',
    'id'      => 'header_logo',
    'label'   => 'Logo para cabezote de la p&aacute;gina',
    'type'    => 'media'
  ));

  new AsifaCustomizerSetting($wp_customize, array(
    'section' => 'title_tagline',
    'id'      => 'member_fallback',
    'label'   => 'Imagen alternativa en caso de que no exista para asociado.',
    'type'    => 'media'
  ));

  //proyecto_fallback
  new AsifaCustomizerSetting($wp_customize, array(
    'section' => 'title_tagline',
    'id'      => 'proyecto_fallback',
    'label'   => 'Imagen alternativa en caso de que no exista para proyecto.',
    'type'    => 'media'
  ));

  /*----------  Cuentas redes sociales  ----------*/
  $wp_customize->add_section('social', array(
    'title'       => 'Redes sociales',
    'description' => 'Solo el nombre de usuario. E.g: Para https://www.facebook.com/<strong>AsifaCol</strong> usar solo <strong>AsifaCol</strong>',
    'priority'    => 30
  ));

  // asifa_supported_social() se puede editar en /utils/helpers.php
  $social = new AsifaSocial();

  foreach ($social->supported as $media) {
    new AsifaCustomizerSetting($wp_customize, array(
      'section' => 'social',
      'id'      => $media['slug'],
      'label'   => $media['name'],
      'type'    => 'text'
    ));
  }
}
add_action('customize_register', 'ka_customize_register');

/*=====  End of WP Customizer  ======*/

function asifa_mce_buttons( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
add_filter( 'mce_buttons_2', 'asifa_mce_buttons' );

function asifa_mce_formats( $init_array ) {
  $styleFormats = array(
    // Each array child is a format with it's own settings
    array(
      'title' => 'Título 2 info',
      'block' => 'h2',
      'classes' => 'asifa-info-title',
      'wrapper' => false,
    ),
    array(
      'title' => 'Small',
      'block' => 'small',
      'classes' => 'asifa-small-text',
      'wrapper' => true,
    ),
  );
  $init_array['style_formats'] = json_encode( $styleFormats );

  return $init_array;

}
add_filter( 'tiny_mce_before_init', 'asifa_mce_formats' );

/*============================================
=            Filter Post Glleries            =
============================================*/
function buildImagesArray($atts) {
  $ids = explode(',', $atts['include']);
  $imgArr = array();
  $cols = !empty( $atts['columns'] ) ? $atts['columns'] : '3';

  $grid = array('m', 't', 'd', 'ld');
  $class = '';

  if ($cols !== '1') {
    foreach ($grid as $key => $screen) {
      $grid[$key] = $screen . '-1of' . $cols;
    }
  } else {
    foreach ($grid as $key => $screen) {
      $grid[$key] = $screen . '-all';
    }
  }

  $class = implode(' ', $grid);
  $size = !empty($atts['size']) ? $atts['size'] : 'thumbnail';

  foreach ($ids as $id) {
    $imgArr[$id] = '';
  }

  return asifa_build_gallery($imgArr, $size, $class);
}

function my_gallery_shortcode( $output = '', $atts, $instance ) {
  $return = $output; // fallback

  $my_result = buildImagesArray( $atts );

  if( !empty( $my_result ) ) {
    $return = $my_result;
  }

  return $return;
}

add_filter( 'post_gallery', 'my_gallery_shortcode', 10, 3 );

/*=====  End of Filter Post Glleries  ======*/
