<?php
namespace VendorName\PluginName\Settings;
use VendorName\PluginName\Plugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
  * An class to create a settings page for the plugin using wordpress-settings-api-class
  *
  * @link https://github.com/tareq1988/wordpress-settings-api-class wordpress-settings-api-class
  * @since 0.3.0
  */
class WPSAC_Page extends Plugin {

  private $settings_api;
  private $section_id = 'options';

  function __construct() {

    $this->settings_api = new \WeDevs_Settings_API();
    $this->settings_fields = array();

    // Process saved options on submit
    if( isset( $_POST['option_page'] ) && $_POST['option_page'] == $this->prefix( $this->section_id ) ) $this->options_container_saved();

    // Create a settings page using wordpress-settings-api-class (Settings > Settings API)
    add_action( 'admin_init', array( $this, 'wpsac_admin_init' ) );
    add_action( 'admin_menu', array( $this, 'wpsac_admin_menu' ) );

  }

  /**
    * Initialize wordpress-settings-api-class
    *
    * @since 0.3.0
    */
  public function wpsac_admin_init() {

    // Flush cache group when settings saved
    if( isset( $_POST['option_page'] ) && $_POST['option_page'] == $this->prefix( $this->section_id ) ) self::$cache->flush_group();

    $this->settings_api->set_sections( $this->get_settings_sections() );
    $this->settings_api->set_fields( $this->get_settings_fields() );
    $this->settings_api->admin_init();
  }

  /**
    * Add menu link in WP Admin
    *
    * @since 0.3.0
    */
  public function wpsac_admin_menu() {
    add_options_page( self::$config->get( 'short_name' ), self::$config->get( 'short_name' ) . ' ' . __( 'Settings', self::$textdomain ) . ' (WPSAC)', 'manage_options', sanitize_title( self::$config->get( 'plugin/meta/Name' ) ), array( $this, 'create_wpsac_settings_page' ) );
  }

  /**
    * Retrieve configuration sections
    *
    * @since 0.3.0
    */
  public function get_settings_sections() {

    $sections = array(

      array(
          'id'    => $this->prefix( $this->section_id ),
          'title' => self::$config->get( 'short_name' ) . ' ' . __( 'Settings', self::$textdomain ) . ' (WPSAC)'
      )
    );

    return $sections;
  }

  /**
   * Returns all the settings fields
   *
   * @return array Settings fields
   * @since 0.3.0
   */
  public function get_settings_fields() {

    $settings_fields = array(
      $this->prefix( $this->section_id ) => array(
        array(
          'name'              => $this->prefix( 'blog_name' ),
          'label'             => __( 'Blog Name', self::$textdomain ),
          'placeholder'       => __( 'Enter a title for your blog' ),
          'default'           => get_bloginfo( 'name' ),
          'type'              => 'text'
        ),
        array(
          'name'              => $this->prefix( 'admin_email' ),
          'label'             => 'Admin E-mail Address',
          'placeholder'       => get_bloginfo( 'admin_email' ),
          'type'              => 'text'
        ),
        array(
          'name'              => $this->prefix( 'checkbox_example' ),
          'label'             => 'A checkbox',
          'default'           => 'on',
          'desc'              => 'Check to Enable',
          'type'              => 'checkbox'
        ),
        array(
          'name'              => $this->prefix( 'radio_button' ),
          'label'             => 'Radio Button ',
          'desc'              => __( 'A simple radio button example.' ),
          'default'           => 'option2',
          'type'              => 'radio',
          'options'           => array(
            'option1' => 'Option 1',
            'option2' => 'Option 2'
          )
        ),
      )
    );

    return $settings_fields;

  }

  /**
    * Create a settings page using wordpress-settings-api-class.
    *
    * @since 0.3.0
    */
  public function create_wpsac_settings_page() {

    echo '<div class="wrap">';
    $this->settings_api->show_navigation();
    $this->settings_api->show_forms();
    echo '</div>';

  }

  /**
    * When settings saved, run optional code to process. This is not elegant,
    *   but WPSAC doesn't have an options saved hook.
    *
    * @since 0.3.2
    */
  private function options_container_saved() {

    // Example - If we wanted to saved the "blog_name" field as an MD5 hash:
    //$_POST[ $this->prefix( $this->section_id ) ][ $this->prefix( 'blog_name' ) ] = md5( $this->prefix( 'blog_name' ) );

  }

}
