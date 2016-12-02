<?php

include 'helpers.php';

function asifa_register_mb() {
  $prefix = '_asifa_';

  /*===========================================
  =            Información general            =
  ===========================================*/
  $project = new_cmb2_box(array(
    'id'           => $prefix . 'proyecto',
    'title'        => 'Informaci&oacute;n General',
    'object_types' => array('proyecto'),
    'context'      => 'normal',
    'priority'     => 'high',
    'show_names'   => true,
  ));

  /*----------  Sinopsis  ----------*/
  $project->add_field(array(
    'name'    => 'Sinopsis',
    'desc'    => '',
    'id'      => $prefix . 'sinopsis',
    'type'    => 'wysiwyg',
    'options' => array(
      'textarea_rows' => 10,
      'teeny'         => true,
      'media_buttons' => false
    )
  ));

  /*----------  Video  ----------*/
  $project->add_field(array(
    'name' => 'URL a video',
    'desc' => 'El link a YouTube o Vimeo',
    'id'   => $prefix . 'video_title',
    'type' => 'oembed',
  ));

  /*=====  End of Información general  ======*/

  /*===========================================
  =            Galería de imágenes            =
  ===========================================*/
  $gallery = new_cmb2_box(array(
    'id'           => $prefix . 'gallery',
    'title'        => 'Galería de imágenes',
    'object_types' => array('proyecto', 'asociado'),
    'context'      => 'normal',
    'priority'     => 'high',
    'show_names'   => true
  ));

  $gallery->add_field(array(
    'name'        => 'Im&aacute;genes',
    'description' => '',
    'id'          => 'imgs',
    'type'        => 'file_list',
    'options'     => array(
      'add_upload_files_text' => 'Agregar Imágenes',  // default: "Add or Upload Files"
      'remove_image_text'     => 'Eliminar Imagen',   // default: "Remove Image"
      'file_text'             => 'Imagen:',           // default: "File:"
      'file_download_text'    => 'Descargar',         // default: "Download"
      'remove_text'           => 'Eliminar',          // default: "Remove"
    )
  ));

  /*=====  End of Galería de imágenes  ======*/

  /*=====================================
  =            Ficha Técnica            =
  =====================================*/
  $credits = new_cmb2_box(array(
    'id'           => $prefix . 'creditos',
    'title'        => 'Ficha T&eacute;cnica',
    'object_types' => array('proyecto'),
    'context'      => 'normal',
    'priority'     => 'high',
    'show_names'   => true
  ));

  $list = asifa_get_credits_list();

  foreach ($list as $value) {
    $credits->add_field(array(
      'name' => htmlentities($value, 0, 'UTF-8'),
      'desc' => '',
      'id' => $prefix . strtolower(remove_accents($value)),
      'type' => 'text'
    ));
  }

  $creditsID = $credits->add_field(array(
    'id' => $prefix . 'credito_adicional',
    'type' => 'group',
    'description' => 'En caso de que no exista el campo, se puede agregar manualmente.',
    'options' => array(
      'group_title' => __('Campo adicional'),
      'add_button' => 'Nuevo campo',
      'remove_button' => 'Eliminar campo',
      'sortable' => true
    )
  ));

  $credits->add_group_field($creditsID, array(
    'name'        => 'Titulo',
    'description' => '',
    'id'          => 'titulo',
    'type'        => 'text'
  ));

  $credits->add_group_field($creditsID, array(
    'name'        => 'Contenido',
    'description' => '',
    'id'          => 'contenido',
    'type'        => 'textarea_small'
  ));

  /*=====  End of Ficha Técnica  ======*/

}
add_filter('cmb2_admin_init', 'asifa_register_mb');
