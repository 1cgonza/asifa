<?php get_header(); ?>
<main id="main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

  <?php if ( is_home() && !is_front_page() ) : ?>
    <header class="archive-header">
      <h1 class="page-title"><?php single_post_title(); ?></h1>
    </header>
  <?php endif; ?>

  <?php
  while ( have_posts() ) : the_post();
    get_template_part( 'layouts/content', get_post_type() );
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