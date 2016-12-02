<?php
// ICONOS
// https://developer.wordpress.org/resource/dashicons/

function flush_rules() {
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rules');

function custom_post_types() {
  register_post_type( 'proyecto',
    array(
      'labels' => array(
        'name'               => 'Proyectos',
        'singular_name'      => 'Proyecto',
        'all_items'          => 'Todos los proyectos',
        'add_new'            => 'Agregar proyecto',
        'add_new_item'       => 'Agregar proyecto',
        'edit'               => 'Editar',
        'edit_item'          => 'Editar proyecto',
        'new_item'           => 'Nuevo proyecto',
        'view_item'          => 'Ver proyecto',
        'search_items'       => 'Buscar proyectos',
        'not_found'          => 'No hay resultados.',
        'not_found_in_trash' => 'No hay elementos en la papelera.',
        'parent_item_colon'  => ''
      ),

      'description'         => '',
      'public'              => true,
      'publicly_queryable'  => true,
      'exclude_from_search' => false,
      'show_ui'             => true,
      'query_var'           => true,
      'menu_position'       => 8,
      'menu_icon'           => 'dashicons-admin-customizer',
      'rewrite'             => array('slug' => 'proyecto', 'with_front' => false),
      'has_archive'         => false,
      'capability_type'     => 'post',
      'hierarchical'        => false,
      'supports'            => array('title', 'thumbnail', 'revisions')
    )
  );

  register_post_type( 'asociado',
    array(
      'labels' => array(
        'name'               => 'Asociados',
        'singular_name'      => 'Asociado',
        'all_items'          => 'Todos los asociados',
        'add_new'            => 'Agregar asociado',
        'add_new_item'       => 'Agregar asociado',
        'edit'               => 'Editar',
        'edit_item'          => 'Editar asociado',
        'new_item'           => 'Nuevo asociado',
        'view_item'          => 'Ver asociado',
        'search_items'       => 'Buscar asociados',
        'not_found'          => 'No hay resultados.',
        'not_found_in_trash' => 'No hay elementos en la papelera.',
        'parent_item_colon'  => ''
      ),

      'description'         => '',
      'public'              => true,
      'publicly_queryable'  => true,
      'exclude_from_search' => false,
      'show_ui'             => true,
      'query_var'           => true,
      'menu_position'       => 8,
      'menu_icon'           => 'dashicons-admin-users',
      'rewrite'             => array('slug' => 'asociado', 'with_front' => false),
      'has_archive'         => false,
      'capability_type'     => 'post',
      'hierarchical'        => false,
      'supports'            => array('title', 'thumbnail', 'revisions')
    )
  );
}
add_action('init', 'custom_post_types');