<?php

include 'utils/custom-post-types.php';
include 'utils/meta-boxes.php';

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
  add_editor_style(array( 'css/editor-style.css', asifa_google_fonts() ));

  register_nav_menus( array(
    'main' => 'Men&uacute; Principal'
  ) );
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

/*=====================================
=            WP Customizer            =
=====================================*/
function ka_customize_register($wp_customize) {
  /*----------  Backgrounds Homepage Section  ----------*/
  $wp_customize->add_setting( 'header_logo' , array(
    'transport' => 'refresh',
  ));

  $wp_customize->add_section( 'header' , array(
    'title'     => 'Logo',
    'priority'  => 30,
  ));

  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'image_control_top', array(
    'label'     => 'Home Page Image - Top',
    'section'   => 'media',
    'mime_type' => 'image',
    'section'   => 'header',
    'settings'  => 'header_logo',
  )));
}
add_action('customize_register', 'ka_customize_register');


/*=====  End of WP Customizer  ======*/
