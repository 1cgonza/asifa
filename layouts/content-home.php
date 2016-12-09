<section id="home-main" class="home-section bg-highlight-1 m-all t-all d-all ld-all">
  <div id="home-galleries" class="m-all t-3of4 d-3of4 ld-3of4">
    <?php
    // ::::: Proyectos :::::  //
    echo get_home_gallery(array(
      'title'          => 'Proyectos',
      'post_type'      => 'proyecto',
      'posts_per_page' => 12,
      'order'          => 'ASC',
      'more_text'      => 'Ver todos los proyectos',
      'grid'           => 'm-1of3 t-1of4 d-1of6 ld-1of6',
      'taxonomy'       => 'portfolio_category'
    ));
    // ----- End Proyectos -----  // ?>

    <div class="section-divider"></div>

    <?php
    // ::::: Asociados :::::  //
    echo get_home_gallery(array(
      'title'          => 'Asociados',
      'post_type'      => 'asociado',
      'posts_per_page' => 30,
      'order'          => 'ASC',
      'more_text'      => 'Conocer todos los asociados',
      'grid'           => 'm-1of3 t-1of4 d-1of6 ld-1of6'
    ));
    // ----- End Asociados -----  // ?>
  </div>

  <?php if ( is_active_sidebar( 'sidebar-home' ) ) { ?>
    <aside id="home-main-sidebar" class="asifa-sidebar bg-highlight-2 m-all t-1of4 d-1of4 ld-1of4">
      <?php dynamic_sidebar( 'sidebar-home' ); ?>
    </aside>
  <?php } ?>
</section>
