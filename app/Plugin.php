<?php
namespace VendorName\PluginName;
use WordPress_ToolKit\ObjectCache;
use WordPress_ToolKit\ConfigRegistry;
use WordPress_ToolKit\Helpers\ArrayHelper;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Plugin extends \WordPress_ToolKit\ToolKit {

  private static $instance;
  public static $textdomain;
  public static $config;

  public static function instance() {

    if ( !isset( self::$instance ) && !( self::$instance instanceof Plugin ) ) {

      self::$instance = new Plugin;

      // Load plugin configuration
      self::$config = self::$instance->init( dirname( __DIR__ ), trailingslashit( dirname( __DIR__ ) ) . 'plugin.json' );
      self::$config->merge( new ConfigRegistry( [ 'plugin' => self::$instance->get_current_plugin_meta( ARRAY_A ) ] ) );

      // Set Text Domain
      self::$textdomain = self::$config->get( 'plugin/meta/TextDomain' ) ?: self::$config->get( 'plugin/slug' );

      // Define plugin version
      if ( !defined( __NAMESPACE__ . '\VERSION' ) ) define( __NAMESPACE__ . '\VERSION', self::$config->get( 'plugin/meta/Version' ) );

      // Load dependecies and load plugin logic
      register_activation_hook( self::$config->get( 'plugin/identifier' ), array( self::$instance, 'activate' ) );
      add_action( 'plugins_loaded', array( self::$instance, 'load_dependencies' ) );

    }

    return self::$instance;

  }

  /**
    * Load plugin classes - Modify as needed, remove features that you don't need.
    *
    * @since 0.2.0
    */
  public function load_plugin() {

    if( !$this->verify_dependencies() ) {
      deactivate_plugins( self::$config->get( 'plugin/identifier' ) );
      return;
    }

    // Add TGM Plugin Activation notices for required/recommended plugins
    new TGMPA();

    // Add admin settings page using Carbon Fields framework
    new Settings\Settings_Page();

    // Add a settings page to the Network Admin (requires multisite)
    if ( is_multisite() ) new Settings\Network_Settings_Page();

    // Alternatively, add admin settings page using wordpress-settings-api-class
    new Settings\WPSAC_Page();

    // Add Customizer panels and options
    new Settings\Customizer_Options();

    // Enqueue scripts and stylesheets
    new EnqueueScripts();

    // Create custom post types
    new PostTypes\PostTypes_Loader();

    // Load custom widgets
    new Widgets\Widget_Loader();

    // Load shortcodes
    new Shortcodes\Shortcode_Loader();

    // Perform core plugin logic
    new Core();

  }

  /**
    * Check plugin dependencies on activation.
    *
    * @since 0.2.0
    */
  public function activate() {

    $this->verify_dependencies( true );

  }

  /**
    * Initialize Carbon Fields and load plugin logic
    *
    * @since 0.2.0
    */
  public function load_dependencies() {

    if( class_exists( 'Carbon_Fields\\Carbon_Fields' ) ) {
      add_action( 'after_setup_theme', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
    } else {
      new TGMPA();
    }

    add_action( 'carbon_fields_fields_registered', array( $this, 'load_plugin' ));

  }

  /**
    * Function to verify dependencies, such as if an outdated version of Carbon
    *    Fields is detected.
    *
    * @param bool $die If true, plugin execution is halted with die(), useful for
    *    outputting error(s) in during activate()
    * @return bool
    * @since 0.2.0
    */
  private function verify_dependencies( $die = false ) {

    // Check if underDEV_Requirements class is loaded
    if( !class_exists( 'underDEV_Requirements' ) ) {
      if( $die ) {
        die( sprintf( __( '<strong>%s</strong>: One or more dependencies failed to load', self::$textdomain ), __( self::$config->get( 'plugin/meta/Name' ) ) ) );
      } else {
        return false;
      }
    }

    $requirements = new \underDEV_Requirements( __( self::$config->get( 'plugin/meta/Name' ), self::$textdomain ), self::$config->get( 'dependencies' ) );

    // Check for WordPress Toolkit
    $requirements->add_check( 'wordpress-toolkit', function( $val, $res ) {
      $wordpress_toolkit_version = defined( '\WordPress_ToolKit\VERSION' ) ? \WordPress_ToolKit\VERSION : null;
      if( !$wordpress_toolkit_version ) {
        $res->add_error( __( 'WordPress ToolKit not loaded.', self::$textdomain ) );
      } else if( version_compare( $wordpress_toolkit_version, self::$config->get( 'dependencies/wordpress-toolkit' ), '<' ) ) {
        $res->add_error( sprintf( __( 'An outdated version of WordPress ToolKit has been detected: %s (&gt;= %s required).', self::$textdomain ), $wordpress_toolkit_version, self::$config->get( 'dependencies/wordpress-toolkit' ) ) );
      }
    });

    // Check for Carbon Fields
    $requirements->add_check( 'carbon_fields', function( $val, $res ) {
      $cf_version = defined('\\Carbon_Fields\\VERSION') ? current( explode( '-', \Carbon_Fields\VERSION ) ) : null;
      if( !$cf_version ) {
        $res->add_error( sprintf( __( 'The <a href="%s" target="_blank">Carbon Fields</a> framework is not loaded.', self::$textdomain ), 'https://carbonfields.net/release-archive/' ) );
      } else if( version_compare( $cf_version, self::$config->get( 'dependencies/carbon_fields' ), '<' ) ) {
        $res->add_error( sprintf( __( 'An outdated version of Carbon Fields has been detected: %s (&gt;= %s required).', self::$textdomain ), $cf_version, self::$config->get( 'dependencies/carbon_fields' ) ) );
      }
    });

    // Display errors if requirements not met
    if( !$requirements->satisfied() ) {
      if( $die ) {
        die( $requirements->notice() );
      } else {
        add_action( 'admin_notices', array( $requirements, 'notice' ) );
        return false;
      }
    }

    return true;

  }

  /**
    * Get Carbon Fields option, with object caching (if available). Currently
    *   only supports plugin options because meta fields would need to have the
    *   cache flushed appropriately.
    *
    * @param string $key The name of the option key
    * @param bool $cache Whether or not to attempt to get cached value
    * @return mixed The value of specified Carbon Fields option key
    * @link https://carbonfields.net/docs/containers-usage/ Carbon Fields containers
    * @since 0.2.0
    *
    */
  public static function get_carbon_plugin_option( $key, $cache = true ) {

    $key = self::prefix( $key );

    if( $cache ) {
      // Attempt to get value from cache, else fetch value from database
      return self::$cache->get_object( $key, function() use ( &$key ) {
        return carbon_get_theme_option( $key );
      });
    } else {
      // Return uncached value
      return carbon_get_theme_option( $key );
    }

  }

  /**
    * Get Carbon Fields network container option (if multisite enabled)
    *
    * @param string $key The name of the option key
    * @param string $container The name of the Carbon Fields network container
    * @param bool $cache Whether or not to attempt to get cached value
    * @param int $site_id The network site ID to use - default: SITE_ID_CURRENT_SITE
    * @return mixed The value of specified Carbon Fields option key
    * @link https://carbonfields.net/docs/containers-usage/ Carbon Fields containers
    * @since 0.5.0
    *
    */
  public static function get_carbon_network_option( $key, $cache = true, $site_id = null ) {

    if( !$site_id ) {
      if( !defined( 'SITE_ID_CURRENT_SITE' ) ) return null;
      $site_id = SITE_ID_CURRENT_SITE;
    }

    $key = self::prefix( $key );

    if( $cache ) {
      // Attempt to get value from cache, else fetch value from database
      return self::$cache->get_object( $key, function() use ( &$site_id, &$key ) {
        return carbon_get_network_option( $site_id, $key );
      }, null, [ 'network_global' => true ] );
    } else {
      // Return uncached value
      return carbon_get_network_option( $site_id, $key );
    }

  }

}
