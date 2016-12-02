<?php get_header(); ?>
<main id="main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>
  <header class="page-header">
    <h1><?php echo esc_html( get_search_query() ); ?></h1>
  </header>

  <?php
  while ( have_posts() ) : the_post();
    get_template_part( 'layouts/content', 'search' );
  endwhile;
    the_posts_pagination( array(
      'prev_text' => '<-',
      'next_text' => '->'
    ) );
  else :
    get_template_part( 'layouts/content', 'none' );
endif;
?>
</main>
<?php get_footer(); ?>