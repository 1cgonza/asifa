<?php get_header();
  if ( have_posts() ) : ?>

  <section id="archive-main" class="archive-section bg-highlight-1 m-all t-all d-all ld-all">
    <header class="page-header">
      <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
    </header>

    <?php
      echo get_home_gallery(array(
        'post_type'      => 'asociado',
        'posts_per_page' => -1,
        'grid'           => 'm-1of3 t-1of4 d-1of8 ld-1of8'
      ));
    ?>
  </section>
  <?php endif;
get_footer(); ?>
