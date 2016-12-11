<article <?php post_class(); ?>>
  <header class="article-header">
    <h1><?php the_title(); ?></h1>
  </header>

  <section class="article-section article-content">
    <?php the_content(); ?>
  </section>

  <footer class="article-footer">
    <p class="tags"><?php the_tags('', ', ', ''); ?></p>
  </footer>
</article>

<?php
  if ( comments_open() || get_comments_number() ) {
    comments_template();
  }
?>
