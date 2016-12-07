<?php

function asifa_wrapper_class() {
  return 'content-wrapper m-all t-9of10 d-4of5 ld-3of4';
}

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

function asifa_get_filters($terms) {
  if ( !$terms || is_wp_error($terms) ) {
    return;
  };

  $filters = array();
  $classes = array();
  $names   = array();

  $filters[] = '<li class="asifa-gallery-filter current" data-filter="*">Todos</li>';

  foreach ($terms as $term) {
    $class = 'filter-' . $term->slug;
    $name = $term->name;

    $li = '<li class="asifa-gallery-filter" data-filter=".' . $class . '">';
      $li .= $name;
    $li .= '</li>';

    $filters[] = $li;
    $classes[] = $class;
    $names[]   = $name;
  }

  return array(
    'filters' => $filters,
    'classes' => $classes,
    'names'   => $names
  );
}
/**
 * get_home_gallery()
 * @param array     $options
 * @param String    $optoins['title']           Section title.
 * @param String    $options['post_type']       Post type name.
 * @param Number    $options['posts_per_page']  Number of posts to show in the gallery.
 * @param String    $options['more_text']       Text to use in the show more button.
 * @param String    $options['grid']            Class names for grid.
 * @param String    $options['order']           Either ASC or DESC to define posts order.
 * @param String    $options['taxonomy']        Taxonomy name for categories or tags to show with item.
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
    $order = array_key_exists('order', $options) ? $options['order'] : 'DESC';
    $taxonomy = array_key_exists('taxonomy', $options) ? $options['taxonomy'] : NULL;

    $HTML = '';

    $loop = new WP_Query(array(
      'post_type'      => $type,
      'posts_per_page' => $number,
      'order'          => $order
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
          $classesArray = get_post_class('gallery-item');
          $title = get_the_title();
          $cats = '';

          if (!is_null($taxonomy)) {
            $filters = asifa_get_filters( get_the_terms($post->ID, $taxonomy) );
            $terms = get_the_terms($post->ID, $taxonomy);
            $cats = join(', ', $filters['names']);
            $classesArray = array_merge($classesArray, $filters['classes']);
          }

          $classes = implode($classesArray, ' ');

          $HTML .= '<li class="' . $classes . ' ' . $grid . '">';
            $HTML .= '<a href="' . get_the_permalink() . '" title="' . $title . '">';
              $HTML .= '<div class="item-header">';
                $HTML .= '<h3 class="item-title">' . $title . '</h3>';

                if (!empty($cats)) {
                  $HTML .= '<div class="item-categories">' . $cats . '</div>';
                }

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
