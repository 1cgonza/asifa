<section id="home-main" class="home-section bg-highlight-1">
  <div id="home-galleries" class="m-all t-all d-3of5 ld-2of3">
    <?php
    // ::::: Proyectos :::::  //
    echo get_home_gallery(array(
      'title'          => 'Proyectos',
      'post_type'      => 'proyecto',
      'posts_per_page' => 12,
      'more_text'      => 'Ver todos los proyectos'
    ));
    // ----- End Proyectos -----  // ?>

    <div class="section-divider"></div>

    <?php
    // ::::: Asociados :::::  //
    echo get_home_gallery(array(
      'title'          => 'Asociados',
      'post_type'      => 'asociado',
      'posts_per_page' => 30,
      'more_text'      => 'Conocer todos los asociados'
    ));
    // ----- End Asociados -----  // ?>
  </div>

  <aside id="home-main-sidebar" class="bg-highlight-2 m-all t-all d-2of5 ld-1of3">
    <h3>¿Quieres ser parte de Asifa?</h3>
  </aside>
</section>
