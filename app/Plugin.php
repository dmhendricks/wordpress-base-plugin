<?php
namespace VendorName\PluginName;
use WordPress_ToolKit\ObjectCache;
use WordPress_ToolKit\ConfigRegistry;
use WordPress_ToolKit\Helpers\ArrayHelper;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Plugin extends \WordPress_ToolKit\ToolKit {

  public static $textdomain;

  function __construct() {

    // Load plugin configuration
    $this->init( dirname( __DIR__ ), trailingslashit( dirname( __DIR__ ) ) . 'plugin.json' );
    self::$config->merge( new ConfigRegistry( [ 'plugin' => $this->get_current_plugin_meta( ARRAY_A ) ] ) );

    // Set Text Domain
    self::$textdomain = self::$config->get( 'plugin/meta/TextDomain' ) ?: self::$config->get( 'plugin/slug' );

    // Define plugin version
    if ( !defined( __NAMESPACE__ . '\VERSION' ) ) define( __NAMESPACE__ . '\VERSION', self::$config->get( 'plugin/meta/Version' ) );

    // Load dependecies and load plugin logic
    register_activation_hook( self::$config->get( 'plugin/identifier' ), array( $this, 'activate' ) );
    add_action( 'plugins_loaded', array( $this, 'load_dependencies' ) );

  }

  /**
    * Load plugin classes - Modify as needed, remove features that you don't need.
    *
    * @since 0.2.0
    */
  public function load_plugin() {

    if( !$this->verify_dependencies( 'carbon_fields' ) ) return;

    // Add TGM plugin activation notices for required/recommended plugins
    new TGMPA();

    // Add admin settings page using Carbon Fields framework
    new Settings\Carbon_Page();

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

    $dependency_check = $this->verify_dependencies( true, array( 'activate' => true, 'echo' => false ) );
    if( $dependency_check !== true ) die( $dependency_check );

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

    if( $this->verify_dependencies( 'carbon_fields' ) === true ) {
      add_action( 'carbon_fields_fields_registered', array( $this, 'load_plugin' ));
    }

  }

  /**
    * Function to verify dependencies, such as if an outdated version of Carbon
    *    Fields is detected.
    *
    * Normally, we wouldn't be so persistant about checking for dependencies and
    *    I would just pass it off to TGMPA, however, if they have an ancient version
    *    of Carbon Fields loaded (via plugin or dependency), it causes problems.
    *
    * @param string|array|bool $deps A string (single) or array of deps to check. `true`
    *    checks all defined dependencies.
    * @param array $args An array of arguments.
    * @return bool|string Result of dependency check. Returns bool if $args['echo']
    *    is false, string if true.
    * @since 0.2.0
    */
  private function verify_dependencies( $deps = true, $args = array() ) {

    if( is_bool( $deps ) && $deps ) $deps = self::$config->get( 'dependencies' );
    if( !is_array( $deps ) ) $deps = array( $deps => self::$config->get( 'dependencies/' . $deps ) );

    $args = ArrayHelper::set_default_atts( array(
      'echo' => true,
      'activate' => true
    ), $args);

    $notices = array();

    foreach( $deps as $dep => $version ) {

      switch( $dep ) {

        case 'php':

          if( version_compare( phpversion(), $version, '<' ) ) {
            $notices[] = __( 'This plugin is not supported on versions of PHP below', self::$textdomain ) . ' ' . self::$config->get( 'dependencies/php' ) . '.' ;
          }
          break;

        case 'wordpress-toolkit':

          $wordpress_toolkit_version = defined( '\WordPress_ToolKit\VERSION' ) ? \WordPress_ToolKit\VERSION : null;

          if( !$wordpress_toolkit_version || version_compare( $wordpress_toolkit_version, $version, '<' ) ) {
            $notices[] = sprintf( __( 'Unable to activate %s. An outdated version of WordPress ToolKit has been detected: %s (&gt;= %s required)', self::$textdomain ), self::$config->get( 'plugin/meta/Name' ), $wordpress_toolkit_version, $version );
          }
          break;

        case 'carbon_fields':

          //if( defined('\\Carbon_Fields\\VERSION') || ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) ) {
          if( !$args['activate'] && !defined('\\Carbon_Fields\\VERSION') ) {
            $notices[] = __( 'An unknown error occurred while trying to load the Carbon Fields framework.', self::$textdomain );
          } else if ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) {
            $notices[] = __( 'An outdated version of Carbon Fields has been detected:', self::$textdomain ) . ' ' . \Carbon_Fields\VERSION . ' (&gt;= ' . self::$config->get( 'dependencies/carbon_fields' ) . ' ' . __( 'required', self::$textdomain ) . ').' . ' <strong>' . self::$config->get( 'plugin/meta/Name' ) . '</strong> ' . __( 'deactivated.', self::$textdomain ) ;
          }
          break;

        }

    }

    if( $notices ) {

      deactivate_plugins( self::$config->get( 'plugin/identifier' ) );

      $notices = '<ul><li>' . implode( "</li>\n<li>", $notices ) . '</li></ul>';

      if( $args['echo'] ) {
        Helpers::show_notice( $notices, [ 'type' => 'error', 'dismissible' => false ] );
        return false;
      } else {
        return $notices;
      }

    }

    return !$notices;

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
  public static function get_carbon_network_option( $key, $container = null, $cache = true, $site_id = null ) {

    if( !$site_id ) {
      if( !defined( 'SITE_ID_CURRENT_SITE' ) ) return null;
      $site_id = SITE_ID_CURRENT_SITE;
    }

    if( !$container ) $container = self::$config->get( 'network/default_options_container' );
    $key = self::prefix( $key );

    if( $cache ) {
      // Attempt to get value from cache, else fetch value from database
      return self::$cache->get_object( $key, function() use ( &$key ) {
        return carbon_get_network_option( $site_id, $key, $container );
      });
    } else {
      // Return uncached value
      return carbon_get_network_option( $site_id, $key, $container );
    }

  }

  /**
    * Get plugin option from WordPress Settings API Class, with object caching
    *   (if available).
    *
    * @param string $key The name of the option key
    * @param string $group_id The group_id of the settings page, as specified
    *   in WPSAC_Page class
    * @param bool $cache Whether or not to attempt to get cached value
    * @return string The value of specified option key
    * @link https://github.com/tareq1988/wordpress-settings-api-class WPSAC options
    * @since 0.3.2
    *
    */
  public static function get_wpsac_plugin_option( $key, $group_id = 'options', $cache = true ) {

    $key = self::prefix( $key );
    $options = array();

    if( $cache ) {
      // Attempt to get value from cache, else fetch value from database
      $options = self::$cache->get_object( $key, function() use ( &$key, &$group_id ) {
        return get_option( self::prefix( $group_id ) );
      });
    } else {
      // Return uncached value
      $options = get_option( self::prefix( $group_id ) );
    }

    return isset( $options[ $key ] ) ? $options[ $key ] : null;

  }

}
