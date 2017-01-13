<?php
/* Template Name: Quienes Somos */

get_header();

  while ( have_posts() ) : the_post();
    get_template_part( 'layouts/content', 'page' );

    $junta = new WP_Query(array(
      'post_type'      => 'asociado',
      'posts_per_page' => -1,
      'order'          => 'ASC',
      'orderby'        => 'meta_value_num',
      'meta_key'       => '_asifa_member_order',
      'meta_query' => array(
        array(
          'key'   => '_asifa_member_group',
          'value' => 'junta'
        )
      )
    ));

    if ( $junta->have_posts() ) : ?>
      <div class="article-footer bg-highlight-4">
        <h3 class="section-title">Junta Directiva</h3>
        <?php while ( $junta->have_posts() ) : $junta->the_post();
        $role = get_post_meta( $post->ID, '_asifa_member_role', true );
        ?>
          <div class="asifa-equipo-item m-1of3 t-1of3 d-1of4 ld-1of5">
            <div class="asifa-equipo-img"><?php the_post_thumbnail('asifa-500x500'); ?></div>
            <p class="asifa-equipo-name"><?php the_title(); ?></p>
            <p class="asifa-equipo-role"><?php echo $role; ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif;

    wp_reset_postdata();

    $equipo = new WP_Query(array(
      'post_type'      => 'asociado',
      'posts_per_page' => -1,
      'order'          => 'ASC',
      'orderby'        => 'meta_value_num',
      'meta_key'       => '_asifa_member_order',
      'meta_query' => array(
        array(
          'key'   => '_asifa_member_group',
          'value' => 'equipo'
        )
      )
    ));

    if ( $equipo->have_posts() ) : ?>
      <div class="article-footer bg-highlight-2">
        <h3 class="section-title">Nuestro Equipo</h3>
        <?php while ( $equipo->have_posts() ) : $equipo->the_post();
        $role = get_post_meta( $post->ID, '_asifa_member_role', true );
        ?>
          <div class="asifa-equipo-item m-1of3 t-1of3 d-1of4 ld-1of5">
            <div class="asifa-equipo-img"><?php the_post_thumbnail('asifa-500x500'); ?></div>
            <p class="asifa-equipo-name"><?php the_title(); ?></p>
            <p class="asifa-equipo-role"><?php echo $role; ?></p>
          </div>
        <?php endwhile; ?>

      </div>
    <?php endif;

  endwhile;


get_footer(); ?>
