<?php get_header();
  while ( have_posts() ) : the_post();
    get_template_part( 'layouts/content', get_post_type() );
  endwhile;

get_footer(); ?>

