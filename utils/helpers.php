<?php

function asifa_wrapper_class($class = '') {
  $classes = 'content-wrapper m-all t-9of10 d-4of5 ld-3of4';
  $ret = !empty($class) ? $class . ' ' . $classes : $classes;
  return $ret;
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

class AsifaSocial {
  public function __construct() {
    $this->supported = array(
      array(
        'slug' => 'facebook',
        'name' => 'Facebook',
        'url'  => 'https://www.facebook.com/',
      ),
      array(
        'slug' => 'twitter',
        'name' => 'Twitter',
        'url'  => 'https://twitter.com/',
      ),
      array(
        'slug' => 'instagram',
        'name' => 'Instagram',
        'url'  => 'https://www.instagram.com/',
      ),
      array(
        'slug' => 'linkedin',
        'name' => 'LinkedIn',
        'url'  => 'https://www.linkedin.com/in/',
      ),
      array(
        'slug' => 'vimeo',
        'name' => 'Vimeo',
        'url'  => 'https://vimeo.com/',
      ),
      array(
        'slug' => 'youtube',
        'name' => 'Youtube',
        'url'  => 'https://vimeo.com/',
      ),
      array(
        'slug' => 'google-plus',
        'name' => 'Google+',
        'url'  => 'https://plus.google.com/+',
      ),
      array(
        'slug' => 'flickr',
        'name' => 'Flickr',
        'url'  => 'https://www.flickr.com/',
      ),
      array(
        'slug' => 'soundcloud',
        'name' => 'Soundcloud',
        'url'  => 'https://soundcloud.com/',
      ),
    );
  }

  public function get_supported_array() {
    return $this->supported;
  }

  public function checkURL($id, $url, $slug) {
    $meta = get_post_meta( $id, '_asifa_' . $slug, true );

    if (!empty($meta) && strpos($url, $meta) === false ) {
      $meta = $url . $meta;
    }

    return $meta;
  }

  public function has_links($id) {
    foreach ($this->supported as $media) {
      $check = $this->checkURL($id, $media['url'], $media['slug']);

      if ($check) {
        return true;
      }
    }

    return false;
  }

  public function get_front_links($id) {
    $res = '<ul class="asifa-social-links">';

    foreach ($this->supported as $media) {
      $url = $this->checkURL($id, $media['url'], $media['slug']);

      if ( !empty($url) ) {
        $res .= '<li class="asifa-social-icon asifa-social-' . $media['slug'] . '">';
          $res .= '<a href="' . $url . '" target="_blank">' . $media['name'] . '</a>';
        $res .= '</li>';
      }
    }

    $res .= '</ul>';

    return $res;
  }
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
  $type     = $options['post_type'];
  $title    = array_key_exists('title', $options) ? $options['title'] : NULL;
  $more     = array_key_exists('more_text', $options) ? $options['more_text'] : NULL;
  $number   = array_key_exists('posts_per_page', $options) ? $options['posts_per_page'] : get_option( 'posts_per_page' );
  $grid     = array_key_exists('grid', $options) ? $options['grid'] : '';
  $order    = array_key_exists('order', $options) ? $options['order'] : 'DESC';
  $orderby  = array_key_exists('orderby', $options) ? $options['orderby'] : 'post_date';
  $taxonomy = array_key_exists('taxonomy', $options) ? $options['taxonomy'] : NULL;

  $HTML = '';

  $loop = new WP_Query(array(
    'post_type'      => $type,
    'posts_per_page' => $number,
    'order'          => $order,
    'orderby'        => $orderby
  ));

  if ($loop->have_posts()) :
    $HTML .= '<div class="asifa-gallery">';
      if ( !is_null($title) ) {
        $HTML .= '<h2 class="section-title">' . $title . '</h2>';
      }

      $HTML .= '<span class="preloader"></span>';

      $HTML .= '<ul class="gallery-wrapper hidden">';

      while ( $loop->have_posts() ) : $loop->the_post();
        $classesArray = get_post_class('gallery-item');
        $title = get_the_title();
        $cats = '';

        $thumbnail = '';

        if ( has_post_thumbnail($post->ID) ) {
          $thumbnail = get_the_post_thumbnail($post->ID, 'asifa-500x500');
        } else {
          if ($type == 'asociado') {
            $thumbID = get_theme_mod('member_fallback');
          } elseif ($type == 'proyecto') {
            $thumbID = get_theme_mod('proyecto_fallback');
          }
          $thumbnail = wp_get_attachment_image($thumbID, 'full');
        }

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

function asifa_build_gallery($imgs, $thumbSize = 'asifa-150xauto', $itemClass = '') {
  $HTML = '<div class="asifa-gallery-ui" itemscope itemtype="http://schema.org/ImageGallery">';

  foreach ($imgs as $id => $url) :
    $small = wp_get_attachment_image_src($id, $thumbSize);
    $large  = wp_get_attachment_image_src($id, 'asifa-2000xauto');

    $HTML .= '<figure class="gallery-item ' . $itemClass . '" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
      $HTML .= '<a href="' . $large[0] . '" itemprop="contentUrl" data-size="' . $large[1] . 'x' . $large[2] . '">';
        $HTML .= '<img src="' . $small[0] . '" itemprop="thumbnail" />';
      $HTML .= '</a>';
    $HTML .= '</figure>';
  endforeach;

  $HTML .= '</div>';

  return $HTML;
}
