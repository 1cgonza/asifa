<?php
  $sinopsis = get_post_meta( $post->ID, '_asifa_sinopsis', true );
  $imgs = get_post_meta( $post->ID, '_asifa_imgs', true );

  $creditsList = asifa_get_credits_list();
  $credits = array();

  foreach ($creditsList as $name) {
    $key = '_asifa_' . strtolower(remove_accents($name));
    $field = get_post_meta( $post->ID, $key, true );

    if (!empty($field)) {
      $credits[$name] = $field;
    }
  }

  $videos = get_post_meta( $post->ID, '_asifa_video', true );

  $iframes = array();
  if (!empty($videos) && !empty($videos[0])) {
    foreach ($videos as $vid) {
      $iframe = wp_oembed_get($vid['oembed_url']);

      if (!empty($iframe)) {
        $iframes[] = $iframe;
      }
    }
  }

  $profileClass = !$credits ? asifa_wrapper_class() : 'article-main-content m-all t-all d-3of5 ld-3of5';
?>
<article <?php post_class('m-all t-all d-all ld-all'); ?>>
  <header class="article-content-wrapper page-header bg-highlight-1">
    <?php the_title('<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>'); ?>
  </header>

  <section id="asifa-proyecto-main" class="article-content-wrapper <?php echo $profileClass; ?>">
    <?php if (!empty($sinopsis)) : ?>
      <?php echo wpautop( $sinopsis); ?>
    <?php endif ?>

    <?php foreach ($iframes as $iframe) : ?>
    <div class="video-wrapper">
      <?php echo $iframe; ?>
    </div>
    <?php endforeach; ?>

    <?php
      if ( !empty($imgs) ) :
        echo asifa_build_gallery($imgs);
      endif;
    ?>

  </section>

  <?php if (!empty($credits)) : ?>
  <section id="asifa-proyecto-aside" class="article-aside-content article-content-wrapper m-all t-all d-2of5 ld-2of5">
    <h4 class="aside-title">Ficha T&eacute;cnica</h4>
    <div id="asifa-creditos-wrapper">
      <?php foreach ($credits as $key => $value) : ?>
        <div class="asifa-credits-row">
          <p class="asifa-credits-title"><?php echo $key; ?></p>
          <p class="asifa-credits-value"><?php echo $value; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <footer class="article-footer">
    <p class="tags"><?php the_tags('', ', ', ''); ?></p>
  </footer>
</article>
