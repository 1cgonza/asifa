<?php get_header();

  if ( is_front_page() ) {
    get_template_part( 'layouts/content', 'home' );
  } else {
    while ( have_posts() ) : the_post();
      get_template_part( 'layouts/content', 'page' );

      if ( comments_open() || get_comments_number() ) {
        comments_template();
      }
    endwhile;
  }

get_footer(); ?>
