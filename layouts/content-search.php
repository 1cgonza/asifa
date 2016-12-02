<article <?php post_class(); ?>>
  <header class="article-header">
    <?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
  </header>

  <section class="article-section article-content">
    <?php the_excerpt();(); ?>
  </section>

  <footer class="article-footer">
    <p class="tags"><?php the_tags('', ', ', ''); ?></p>
  </footer>
</article>