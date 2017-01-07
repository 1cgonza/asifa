<?php

class Create_Inputs {
  public function __construct($group, $key, $member) {
    $this->disabled = $group == 'asociados';
    $this->group = $group;
    $this->key = $key;
    $this->member = $member;

    $this->buildAttrs();
  }

  private function buildAttrs() {
    $inputNames = array('id', 'order', 'group', 'role');
    $inputs = array();

    foreach ($inputNames as $name) {
      $attrs = array(
        'class' => $name,
        'name' => $this->group . '-' . $this->key . '[' . $name . ']',
        'value' => array_key_exists($name, $this->member) ? $this->member[$name] : $this->group,
        'type' => 'hidden'
      );

      if ($name == 'role') {
        unset($attrs['type']);
        $attrs['placeholder'] = 'Cargo...';
      }

      $inputs[] = $attrs;
    }

    $this->inputs = $inputs;
  }

  public function render() {
    $res = '';

    foreach ($this->inputs as $input) {
      $res .= '<input';
        foreach ($input as $attr => $value) {
          $res .= ' ' . $attr . '="' . $value . '"';
        }

        if ($this->disabled) {
          $res .= ' disabled';
        }
      $res .= '>';
    }

    return $res;
  }
}

class Asifa_Admin_Equipo {
  private $slug;
  private $version;

  public function __construct( $slug, $version ) {
    $this->slug = $slug;
    $this->version = $version;

    $this->intructions = array(
      'Agregar' => 'Arrastra al miembro a la sección donde pertenece y asigna el cargo en el campo de texto.',
      'Ordenar' => 'Puedes re-ordenarlos arrastrándolos dentro de cada una de las secciones.',
      'Eliminar' => 'Arrastra a la persona a la sección de <i>Miembros (en la izquierda)</i>.',
      'Guardar' => 'Para guardar los cambios, hacer clic en el botón <strong>Actualizar</strong>.'
    );
  }

  public function enqueue_styles() {
    wp_enqueue_style( $this->slug, get_template_directory_uri() . '/css/admin.min.css', array(), $this->version, 'all' );
  }

  public function enqueue_scripts() {
    wp_enqueue_script( $this->slug, get_template_directory_uri() . '/js/admin.min.js', array(), $this->version, true );
  }

  public function register_users_options() {
    add_menu_page(
      'Equipo Asifa',         // Page title
      'Equipo Asifa',         // Menu title
      'manage_options',       // Capabilities
      'asifa-users',          // Menu slug
      array($this, 'render'), // Function to output
      'dashicons-groups',     // Icon
      9                       // Position
    );
  }

  private function get_asifa_users() {
    global $post;
    $loop = new WP_Query(array(
      'post_type'      => 'asociado',
      'posts_per_page' => -1,
      'order'          => 'ASC',
      'orderby'        => 'title'
    ));

    if ( !$loop->have_posts() ) {
      return;
    }

    $members = array();
    $groups = array(
      'junta',
      'equipo',
      'asociados'
    );

    foreach ($groups as $group) {
      $members[$group] = array();
    }

    function get_member_data($id) {
      $role = get_post_meta($id, '_asifa_member_role', true);
      $order = get_post_meta($id, '_asifa_member_order', true);

      $img = '';

      if ( has_post_thumbnail($id) ) {
        $img = get_the_post_thumbnail($id);
      } else {
        $imgID = get_theme_mod('member_fallback');
        $img = wp_get_attachment_image($imgID, 'full');
      }

      return array(
        'id' => $id,
        'name' => get_the_title($id),
        'role' => $role,
        'order' => $order,
        'img' => $img
      );
    }

    while ( $loop->have_posts() ) : $loop->the_post();
      $group = get_post_meta($post->ID, '_asifa_member_group', true);

      if (!empty($group)) {
        $members[$group][] = get_member_data($post->ID);
      } else {
        $members['asociados'][] = get_member_data($post->ID);
      }
    endwhile;

    function orderBy($data, $field) {
      $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
      usort($data, create_function('$a,$b', $code));
      return $data;
    }

    foreach ($members as $key => $array) {
      $members[$key] = orderBy($array, 'order');
    }

    return array('members' => $members, 'groups' => $groups);
  }

  private function get_group_section($members, $group) {
    if ( empty($members[$group]) ) {
      return;
    }

    $section = '';
    foreach ($members[$group] as $key => $member) {
      $section .= '<li class="asifa-member-draggable">';
        $section .= '<div class="asifa-member-img">' . $member['img'] . '</div>';
        $section .= '<p class="asifa-member-name">' . $member['name'] . '</p>';

        $inputs = new Create_Inputs( $group, $key, $member);
        $section .= $inputs->render();

      $section .= '</li>';
    }

    return $section;
  }

  public function render() {
    if ( !empty($_POST) ) {
      foreach ($_POST as $member) {
        update_post_meta( $member['id'], '_asifa_member_role', $member['role'] );
        update_post_meta( $member['id'], '_asifa_member_order', $member['order'] );
        update_post_meta( $member['id'], '_asifa_member_group', $member['group'] );
      }
    }

    $users = $this->get_asifa_users();
    $members = $users['members'];
    $groups = $users['groups'];

    $HTML = '<h1 class="wp-heading-inline">Equipo Asifa</h1>';

    /*----------  Instructions  ----------*/
    $HTML .= '<div class="asifa-admin-description">';
      $HTML .= '<h2>Instrucciones:</h2>';

      foreach ($this->intructions as $title => $text) {
        $HTML .= '<p><strong>' . $title . ': </strong>' . $text . '</p>';
      }
    $HTML .= '</div>';

    /*----------  Form  ----------*/
    $HTML .= '<form id="asifa-members-form" method="post">';

      /*----------  Asociados  ----------*/
      $HTML .= '<div id="asifa-asociados-wrapper">';
        $HTML .= '<h2 class="group-title">Miembros</h2>';
        $HTML .= '<ul id="asifa-list-asociados">';
          $HTML .= $this->get_group_section($members, 'asociados');
        $HTML .= '</ul>';
      $HTML .= '</div>';

      $HTML .= '<div id="asifa-sections-wrapper">';

        /*----------  Junta  ----------*/
        $HTML .= '<h2 class="group-title">Junta Directiva</h2>';
        $HTML .= '<ul id="asifa-list-junta" class="asifa-admin-drop-area" data-group="junta">';
          $HTML .= $this->get_group_section($members, 'junta');
        $HTML .= '</ul>';

        /*----------  Equipo  ----------*/
        $HTML .= '<h2 class="group-title">Nuestro Equipo</h2>';
        $HTML .= '<ul id="asifa-list-equipo" class="asifa-admin-drop-area" data-group="equipo">';
          $HTML .= $this->get_group_section($members, 'equipo');
        $HTML .= '</ul>';

        $HTML .= '<p><input class="button-primary" type="submit" value="Actualizar"/></p>';
      $HTML .= '</div>';
    $HTML .= '</form>';
    echo $HTML;
  }
}
