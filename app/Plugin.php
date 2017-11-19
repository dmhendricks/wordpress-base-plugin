<?php
namespace VendorName\PluginName;
use WordPress_ToolKit\ObjectCache;
use WordPress_ToolKit\ConfigRegistry;
use WordPress_ToolKit\PluginTools;
use WordPress_ToolKit\Helpers\ArrayHelper;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Config;

class Plugin {

  public static $textdomain;
  public static $config;
  protected static $cache;

  function __construct() {

    // Get plugin properties and meta data
    $plugin_obj = new PluginTools( __DIR__ );
    $plugin_data = $plugin_obj->get_current_plugin_data( ARRAY_A );

    self::$config = new ConfigRegistry( $plugin_data['path'] . 'plugin.json' );
    self::$config = self::$config->merge( new ConfigRegistry( [ 'plugin' => $plugin_data ] ) );
    self::$textdomain = self::$config->get( 'plugin/meta/TextDomain' ) ?: self::$config->get( 'plugin/slug' );

    // Define plugin VERSION constant
    if ( !defined( __NAMESPACE__ . '\VERSION' ) ) define( __NAMESPACE__ . '\VERSION', self::$config->get( 'plugin/meta/Version' ) );

    // Initialize ObjectCache
    self::$cache = new ObjectCache( self::$config );

    // Verify dependecies and load plugin logic
    register_activation_hook( self::$config->get( 'plugin/identifier' ), array( $this, 'activate' ) );
    add_action( 'plugins_loaded', array( $this, 'init' ) );

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
  public function init() {

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
    * Load plugin classes
    *
    * @since 0.2.0
    */
  public function load_plugin() {

    if( !$this->verify_dependencies( 'carbon_fields' ) ) return;

    // Add TGM plugin activation notices for required/recommended plugins
    new TGMPA();

    // Add admin settings page using Carbon Fields framework
    new Settings\Carbon_Page();

    // Alternatively, add admin settings page using wordpress-settings-api-class
    new Settings\WPSAC_Page();

    // Enqueue scripts and stylesheets
    new EnqueueScripts();

    // Perform core plugin logic
    new Core();

    // Create custom post types
    new PostTypes\Clients();

    // Load custom widgets
    new Widgets\WidgetLoader();

    // Load shortcodes
    new Shortcodes\ShortcodeLoader();

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
        Helpers::show_notice($notices, 'error', false);
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
    * @return mixed The value of specified Carbon Fields option key
    * @link https://carbonfields.net/docs/containers-usage/ Carbon Fields containers
    * @since 0.2.0
    *
    */
  public static function get_plugin_option( $key, $cache = true ) {
    $key = $this->prefix( $key );

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
    * A wrapper for the plugin's data fiala prefix as defined in $config
    *
    * @param string|null $str The string/field to prefix
    * @return string Prefixed string/field value
    * @since 0.2.0
    */
  public static function prefix( $field_name = null ) {
    return $field_name !== null ? self::$config->get( 'prefix' ) . $field_name : self::$config->get( 'prefix' );
  }

  /**
    * Returns true if WP_ENV is anything other than 'development' or 'staging'.
    *   Useful for determining whether or not to enqueue a minified or non-
    *   minified script (which can be useful for debugging via browser).
    *
    * @return bool
    * @since 0.1.0
    */
  public static function is_production() {
    return ( !defined( 'WP_ENV' ) || ( defined('WP_ENV' ) && !in_array( WP_ENV, array('development', 'staging') ) ) );
  }

  /**
    * Returns true if request is via Ajax.
    *
    * @return bool
    * @since 0.1.0
    */
  public function is_ajax() {
    return defined('DOING_AJAX') && DOING_AJAX;
  }

}
