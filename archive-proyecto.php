<?php get_header();
  if ( have_posts() ) :
    $terms = get_terms(array(
      'taxonomy' => 'portfolio_category',
      'hide_empty' => true
    ));

    $filters = asifa_get_filters($terms);
  ?>

  <section id="archive-main" class="archive-section m-all t-all d-all ld-all">
    <header class="page-header bg-highlight-1">
      <?php the_archive_title( '<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>' ); ?>
    </header>

    <?php
      if (!empty($filters)) {
        $nav = '<ul class="asifa-gallery-filters ' . asifa_wrapper_class() . '">';
          $nav .= implode('', $filters['filters']);
        $nav .= '</ul>';
        echo $nav;
      }

      echo get_home_gallery(array(
        'post_type'      => 'proyecto',
        'posts_per_page' => -1,
        'grid'           => 'm-1of3 t-1of4 d-1of8 ld-1of8',
        'order'          => 'ASC',
        'taxonomy'       => 'portfolio_category'
      ));
    ?>
  </section>
  <?php endif;
get_footer(); ?>
