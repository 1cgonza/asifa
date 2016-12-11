<?php
  $profesion = get_post_meta( $post->ID, '_asifa_profesion', true );
  $email = get_post_meta( $post->ID, '_asifa_email', true );
  $url = get_post_meta( $post->ID, '_asifa_url', true );
  $bio = get_post_meta( $post->ID, '_asifa_bio', true );
  $imgs = get_post_meta( $post->ID, '_asifa_imgs', true );
  $vids = get_post_meta( $post->ID, '_asifa_video', true );
  $portrait = get_the_post_thumbnail($post->ID, 'asifa-500x500');
  $social = new AsifaSocial();
?>
<article <?php post_class('m-all t-all d-all ld-all'); ?>>
  <header class="page-header bg-highlight-1">
    <?php the_title('<h1 class="page-title ' . asifa_wrapper_class() . '">', '</h1>'); ?>
  </header>

  <section class="article-section article-content m-all">
    <div id="asifa-asociado-perfil" class="article-content-section m-all t-all d-1of4 ld-1of5">
      <?php
        echo $portrait;
        echo $social->get_front_links($post->ID);
      ?>
    </div>

    <div id="asifa-asociado-creditos" class="article-content-section m-all t-all d-2of5 ld-2of5">
      <div id="asifa-creditos-wrapper">
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
            <p class="asifa-credits-title">Sitio web:</p>
            <p class="asifa-credits-value"><?php echo $url; ?></p>
          </div>
        <?php endif; ?>
      </div>

      <?php if ( !empty($bio) ) : ?>
        <div class="asifa-credits-bio">
        <?php echo wpautop($bio); ?>
      </div>
      <?php endif; ?>

      <?php
        if ( !empty($imgs) ) :
          foreach ($imgs as $id => $fullURL) {
            echo wp_get_attachment_image($id, 'asifa-500x500');
          }
        endif;
      ?>
    </div>

    <div id="asifa-asociado-videos" class="article-content-section m-all t-all d-2of5 ld-2of5">
      <?php if ( !empty($vids) ) : foreach ($vids as $vid) : ?>
        <?php if ( !empty( $vid['oembed_url'] ) ) : ?>
        <div class="video-wrapper">
          <?php echo wp_oembed_get(esc_url( $vid['oembed_url'] )); ?>
        </div>
      <?php endif; endforeach; endif; ?>
    </div>
  </section>

  <footer class="article-footer">
    <p class="tags"><?php the_tags('', ', ', ''); ?></p>
  </footer>
</article>
