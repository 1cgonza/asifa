<article <?php post_class(); ?>>
  <header class="article-content-wrapper page-header bg-highlight-1">
    <?php the_title('<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>'); ?>
    <?php
    if ( has_post_thumbnail() ) : ?>
      <div class="page-header-img" style="background-image:url(<?php the_post_thumbnail_url(); ?>)"></div>
    <?php endif ?>
  </header>

  <section class="article-section article-content <?php echo asifa_wrapper_class(); ?>">
    <?php the_content(); ?>
  </section>
</article>