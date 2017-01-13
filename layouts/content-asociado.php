<?php
  $profesion = get_post_meta( $post->ID, '_asifa_profesion', true );
  $email = antispambot( get_post_meta( $post->ID, '_asifa_email', true ) );
  $url = get_post_meta( $post->ID, '_asifa_url', true );
  $bio = get_post_meta( $post->ID, '_asifa_bio', true );
  $imgs = get_post_meta( $post->ID, '_asifa_imgs', true );
  $portrait = '';

  if ( has_post_thumbnail($post->ID) ) {
    $portrait = get_the_post_thumbnail($post->ID, 'asifa-500x500');
  } else {
    $portraitID = get_theme_mod('member_fallback');
    $portrait = wp_get_attachment_image($portraitID, 'full');
  }

  $videos = get_post_meta( $post->ID, '_asifa_video', true );
  $hasVideos = false;
  $iframes = array();

  if (!empty($videos) && !empty($videos[0])) {
    foreach ($videos as $vid) {
      $iframe = wp_oembed_get($vid['oembed_url']);

      if (!empty($iframe)) {
        $iframes[] = $iframe;
        $hasVideos = true;
      }
    }
  }

  $profileClass = !$hasVideos ? asifa_wrapper_class() : 'article-content-wrapper article-main-content m-all t-all d-3of5 ld-3of5';

  $social = new AsifaSocial();
?>
<article <?php post_class('m-all t-all d-all ld-all'); ?>>
  <header class="article-content-wrapper page-header bg-highlight-1">
    <?php the_title('<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>'); ?>
  </header>

  <section id="asifa-asociado-perfil" class="<?php echo $profileClass; ?>">
    <div class="asifa-profile-portrait m-all t-all d-1of6 ld-1of6">
      <?php echo $portrait; ?>
    </div>

    <div id="asifa-creditos-wrapper" class="m-all t-all d-4of5 ld-4of5">
      <?php if (!empty($profesion)) : ?>
        <div class="asifa-credits-row">
          <p class="asifa-credits-title">Profesi&oacute;n:</p>
          <p class="asifa-credits-value"><?php echo $profesion; ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($email)) : ?>
        <div class="asifa-credits-row">
          <p class="asifa-credits-title">Correo electr&oacute;nico:</p>
          <p class="asifa-credits-value"><?php echo $email; ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($url)) : ?>
        <div class="asifa-credits-row">
          <p class="asifa-credits-title">Sitio web oficial:</p>
          <p class="asifa-credits-value"><a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></p>
        </div>
      <?php endif; ?>

      <?php if ( $social->has_links($post->ID) ) : ?>
        <div class="asifa-credits-row">
          <p class="asifa-credits-title">En redes sociales:</p>
          <div class="asifa-credits-value"><?php echo $social->get_front_links($post->ID); ?></div>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( !empty($bio) ) : ?>
      <div class="asifa-credits-bio">
        <?php echo apply_filters('the_content', $bio); ?>
      </div>
    <?php endif; ?>

    <?php
      if ( !empty($imgs) ) :
        echo asifa_build_gallery($imgs);
      endif;
    ?>
  </section>

  <?php if ($hasVideos) : ?>
  <section id="asifa-asociado-videos" class="article-content-wrapper article-aside-content m-all t-all d-2of5 ld-2of5">
    <?php foreach ($iframes as $iframe) : ?>
    <div class="video-wrapper">
      <?php echo $iframe; ?>
    </div>
    <?php endforeach; ?>
  </section>
  <?php endif; ?>
</article>

<footer class="article-footer bg-highlight-4">
  <h4 class="section-title">Otros Asociados</h4>
  <?php
    echo get_home_gallery(array(
      'post_type'      => get_post_type(),
      'posts_per_page' => 6,
      'grid'           => 'm-1of2 t-1of3 d-1of6 ld-1of6',
      'orderby'        => 'rand'
    ));
  ?>
</footer>
