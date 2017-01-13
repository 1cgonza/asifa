<?php get_header();

  if ( is_front_page() ) {
    get_template_part( 'layouts/content', 'home' );
  } else {
    while ( have_posts() ) : the_post();
      get_template_part( 'layouts/content', 'page' );
      get_template_part('layouts/gallery', 'ui');
    endwhile;
  }

get_footer(); ?>
