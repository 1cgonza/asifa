<?php

function asifa_get_credits_list() {
  return array(
    'Dirección',
    'Duración',
    'Formato',
    'Sonido',
    'Fecha',
    'Diseño Sonoro',
    'Música',
    'Montaje',
    'Motion Graphics',
    'Animación',
    'Producción',
    'Producción ejecutiva'
  );
}

function asifa_supported_social() {
  return array(
    'facebook',
    'twitter'
  );
}
/**
 *
 * @param array     $options
 * @param String    $optoins['title']           Section title
 * @param String    $options['post_type']       Post type name
 * @param Number    $options['posts_per_page']  Number of posts to show in the gallery
 * @param String    $options['more_text']       Text to use in the show more button
 * @param String    $options['grid']            Class names for grid
 * USE:
 * echo get_home_gallery(array(
    'title'          => 'Asociados',
    'post_type'      => 'asociado',
    'posts_per_page' => 30,
    'more_text'      => 'Conocer todos los asociados'
  ));
 */
function get_home_gallery($options) {
    // Abortar si no esta definido el post_type
    if (!array_key_exists('post_type', $options)) {
      return;
    }

    global $post;
    $type = $options['post_type'];
    $title = array_key_exists('title', $options) ? $options['title'] : NULL;
    $more = array_key_exists('more_text', $options) ? $options['more_text'] : NULL;
    $number = array_key_exists('posts_per_page', $options) ? $options['posts_per_page'] : get_option( 'posts_per_page' );
    $grid = array_key_exists('grid', $options) ? $options['grid'] : '';

    $HTML = '';

    $loop = new WP_Query(array(
      'post_type'      => $type,
      'posts_per_page' => $number
    ));

    if ($loop->have_posts()) :
      $HTML .= '<div class="asifa-gallery">';
        if ( !is_null($title) ) {
          $HTML .= '<h2 class="section-title">' . $title . '</h2>';
        }

        $HTML .= '<span class="preloader"></span>';

        $HTML .= '<ul class="gallery-wrapper hidden">';

        while ( $loop->have_posts() ) : $loop->the_post();
          $thumbnail = get_the_post_thumbnail($post->ID, 'asifa-500x500');
          $title = get_the_title();
          $classes = implode( get_post_class('gallery-item'), ' ' );

          $HTML .= '<li class="' . $classes . ' ' . $grid . '">';
            $HTML .= '<a href="' . get_the_permalink() . '" title="' . $title . '">';
              $HTML .= '<div class="item-header">';
                $HTML .= '<h3 class="item-title">' . $title . '</h3>';
                $HTML .= '<div class="item-categories"></div>';
              $HTML .= '</div>';

              $HTML .= $thumbnail;
            $HTML .= '</a>';
          $HTML .= '</li>';

        endwhile;
        $HTML .= '</ul>';
      $HTML .= '</div>';
    endif;
    wp_reset_postdata();

    if ( !is_null($more) ) {
      $HTML .= '<a class="long-btn" href="' . get_post_type_archive_link($type) . '" title="' . $title . '">' . $more . '</a>';
    }

    return $HTML;
  }
