<?php
namespace VendorName\PluginName\Settings;
use VendorName\PluginName\Plugin;
use Carbon_Fields\Datastore\Datastore\Serialized_Theme_Options_Datastore;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
  * A class to create a settings page in Network Admin
  *
  * @link https://carbonfields.net/docs/containers-network/ Carbon Fields Network Container
  * @since 0.5.0
  */
class Network_Settings_Page extends Plugin {

  public function __construct() {

    // Flush the cache when settings are saved
    add_action( 'carbon_fields_network_container_saved', array( $this, 'options_saved_hook' ) );

    // Create tabbed plugin options page (Settings > Plugin Name)
    $this->create_network_options_page();

  }

  /**
    * Create network options/settings page in WP Network Admin > Settings > Global Settings
    *
    * @since 0.5.0
    */
  public function create_network_options_page() {

    $container_name = $this->prefix( self::$config->get( 'network/default_options_container' ) );
    Container::make( 'network', $container_name, __( 'Global Settings', self::$textdomain ) )
      ->set_page_parent( 'settings.php' )
      ->add_tab( __( 'General', self::$textdomain ), array(
        Field::make( 'textarea', $this->prefix( 'network_site_footer' ), __( 'WP Admin Site Footer', self::$textdomain ) )
          ->help_text( __( 'Replaces the WP Admin footer text. Leave blank for default.', self::$textdomain ) )
          ->set_rows( 2 )
      )
    );

  }

  /**
    * Callback when settings are saved
    */
  public function options_saved_hook() {

    // Flush the plugin group cache
    self::$cache->flush_group();

  }

}
