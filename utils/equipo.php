<?php

class Asifa_Equipo {
  protected $loader;
  protected $slug;
  protected $version;

  public function __construct() {
    $this->slug = 'asifa-admin';
    $this->version = '1.0.0';

    $this->load_dependencies();
    $this->define_hooks();
  }

  private function load_dependencies() {
    require_once 'plugins/asifa-admin-loader.php';
    require_once 'plugins/asifa-equipo-admin.php';

    $this->loader = new Asifa_Admin_Loader();
  }

  private function define_hooks() {
    $plugin_admin = new Asifa_Admin_Equipo( $this->slug, $this->get_version() );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_users_options' );
  }

  public function run() {
    $this->loader->run();
  }

  public function get_loader() {
    return $this->loader;
  }

  public function get_version() {
    return $this->version;
  }
}

function run_asifa_admin() {
  $plugin = new Asifa_Equipo();
  $plugin->run();
}
run_asifa_admin();
