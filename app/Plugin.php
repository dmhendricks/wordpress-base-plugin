<?php
namespace VendorName\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Plugin {

  public static $settings;
  public static $textdomain;

  function __construct( $_settings ) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['data']['TextDomain'];
    self::$settings = $_settings;

    // Verify dependecies and load plugin logic
    register_activation_hook( self::$settings['plugin_file'], array( $this, 'activate' ) );
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

    add_action( 'after_setup_theme', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );

    if( $this->verify_dependencies( 'carbon_fields' ) === true ) {
      add_action( 'carbon_fields_loaded', array( $this, 'load_plugin' ));
    }

  }

  /**
    * Load plugin classes
    *
    * @since 0.2.0
    */
  public function load_plugin() {

    if( !$this->verify_dependencies( 'carbon_fields' ) ) return;

    // Add admin settings page(s)
    new Settings();

    // Enqueue scripts and stylesheets
    new EnqueueScripts();

    // Perform core plugin logic
    new Core();

    // Create custom post types - dependency requires PHP 5.4 or higher
    //new CPT();

    // Load custom widgets
    new WidgetLoader();

    // Load shortcodes
    new Shortcodes();

  }

  /**
    * Function to verify dependencies, such as if an outdated version of Carbon
    *    Fields is detected.
    *
    * @param string|array|bool $deps A string (single) or array of deps to check. `true`
    *    checks all defined dependencies.
    * @param array $args An array of arguments.
    * @return bool|string Result of dependency check. Returns bool if $args['echo']
    *    is false, string if true.
    * @since 0.2.0
    */
  private function verify_dependencies( $deps = true, $args = array() ) {

    if( is_bool( $deps ) && $deps ) $deps = self::$settings['deps'];
    if( !is_array( $deps ) ) $deps = array( $deps => self::$settings['deps'][$deps] );

    $args = Utils::set_default_atts( array(
      'echo' => true,
      'activate' => true
    ), $args);

    $notices = array();

    foreach( $deps as $dep => $version ) {

      switch( $dep ) {

        case 'php':

          if( version_compare( phpversion(), $version, '<' ) ) {
            $notices[] = __( 'This plugin is not supported on versions of PHP below', self::$textdomain ) . ' ' . self::$settings['deps']['php'] . '.' ;
          }
          break;

        case 'carbon_fields':

          //if( defined('\\Carbon_Fields\\VERSION') || ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) ) {
          if( !$args['activate'] && !defined('\\Carbon_Fields\\VERSION') ) {
            $notices[] = __( 'An unknown error occurred while trying to load the Carbon Fields framework.', self::$textdomain );
          } else if ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) {
            $notices[] = __( 'An outdated version of Carbon Fields has been detected:', self::$textdomain ) . ' ' . \Carbon_Fields\VERSION . ' (&gt;= '.self::$settings['deps']['carbon_fields'] . ' ' . __( 'required', self::$textdomain ) . ').' . ' <strong>' . self::$settings['data']['Name'] . '</strong> ' . __( 'deactivated.', self::$textdomain ) ;
          }
          break;

        }

    }

    if( $notices ) {

      deactivate_plugins( self::$settings['plugin_file'] );

      $notices = '<ul><li>' . implode( "</li>\n<li>", $notices ) . '</li></ul>';

      if( $args['echo'] ) {
        Utils::show_notice($notices, 'error', false);
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
  public function get_plugin_option( $key, $cache = true ) {
    $key = $this->prefix( $key );

    if( $cache ) {
      // Attempt to get value from cache, else fetch value from database
      return Cache::get_object( $key, function() use ( &$key ) {
        return carbon_get_theme_option( $key );
      });
    } else {
      // Return uncached value
      return carbon_get_theme_option( $key );
    }

  }

  /**
    * Return constant, if defined (with filter validation, if specified)
    *
    * Example usage:
    *    echo $this->get_const( 'DB_HOST' ); // MySQL host name
    *    echo $this->get_const( 'MY_BOOLEAN_CONST', FILTER_VALIDATE_BOOLEAN );
    *       // null if undefined, true if valid boolean, else false
    *
    * @param string $const The name of constant to retrieve.
    * @param const $filter_validate filter_var() filter to apply (optional).
    *    Valid values: http://php.net/manual/en/filter.filters.validate.php
    * @return mixed Value of constant if specified, else null.
    * @since 0.2.0
    */
  public static function get_const( $const, $filter_validate = null ) {

    if( !defined( $const ) ) {
      return null;
    } else if( $filter_validate ) {
      return filter_var( constant( $const ), $filter_validate);
    }
    return constant( $const );

  }

  /**
    * A wrapper for the plugin's data fiala prefix as defined in $settings
    *
    * @param string|null $str The string/field to prefix
    * @return string Prefixed string/field value
    * @since 0.2.0
    */
  public function prefix( $field_name = null ) {
    return $field_name !== null ? self::$settings['prefix'] . $field_name : self::$settings['prefix'];
  }

  /**
    * Returns true if WP_ENV is anything other than 'development' or 'staging'.
    *   Useful for determining whether or not to enqueue a minified or non-
    *   minified script (which can be useful for debugging via browser).
    *
    * @return bool
    * @since 0.1.0
    */
  public function is_production() {
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
