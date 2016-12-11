<article <?php post_class('m-all t-all d-all ld-all'); ?>>
  <header class="page-header bg-highlight-1">
    <?php the_title('<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>'); ?>
  </header>

  <section class="article-section article-content m-9of10 t-a4of5 d-6of7 ld-3of5">
    <?php the_content(); ?>
  </section>

  <footer class="article-footer">
    <p class="tags"><?php the_tags('', ', ', ''); ?></p>
  </footer>
</article>
