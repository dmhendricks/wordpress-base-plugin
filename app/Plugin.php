<?php
namespace VendorName\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Plugin {

  public static $settings;
  public static $textdomain;
  public static $prefix;

  function __construct($_settings) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['textdomain'];
    self::$prefix     = $_settings['prefix'];
    self::$settings   = $_settings;

    // Initialize Carbon Fields and Check Loded Version
    add_action( 'plugins_loaded', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
    add_action( 'carbon_fields_loaded', array($this, 'load_plugin') );

  }

  public function load_plugin() {

    if(!$this->verify_dependencies()) return;

    // Add admin settings page(s)
    new Settings();

    // Enqueue scripts
    new EnqueueScripts();

    // Core plugin logic
    new Core();

    // Create Custom Post Type(s)
    new CPT();

    // Create custom widgets
    new WidgetLoader();

    // Deploy shortcodes
    new Shortcodes;

  }

  /**
    * Function to verify dependencies, such as if an outdated version of Carbon
    *    Fields is detected.
    *
    * @return bool
    */
  private function verify_dependencies() {

    $error = null;

    if( $this->is_php_version( self::$settings['deps']['php'], '<' ) ) {
      $error = '<strong>' . self::$settings['data']['Name'] . ':</strong> ' . __('This plugin is not supported on versions of PHP under' . ' ' . self::$settings['deps']['php'] . '.' );
    } else if(!defined('\\Carbon_Fields\\VERSION')) {
      $error = '<strong>' . self::$settings['data']['Name'] . ':</strong> ' . __('A fatal error occurred while trying to load dependencies.');
    } else if( version_compare( \Carbon_Fields\VERSION, self::$settings['deps']['carbon_fields'], '<' ) ) {
      $error = '<strong>' . self::$settings['data']['Name'] . ':</strong> ' . __('Unable to load. An outdated version of Carbon Fields has been loaded:' . ' ' . \Carbon_Fields\VERSION) . ' (&gt;= '.self::$settings['deps']['carbon_fields'] . ' ' . __('required') . ')';
    }

    if($error) Utils::show_notice($error, 'error', false);
    return !$error;

  }

  /**
    * Get Carbon Fields option, with object caching (if available)
    *
    * @return bool
    */
  public function get_plugin_option( $key, $cache = true, $source = null ) {

    if( $cache ) {
      // Attempt to get value from cache, else return value from database
      $prefix = self::$prefix; // For PHP 5.3 compatibility
      return Cache::get_object( self::$prefix . $key, function() use (&$key, &$source, &$prefix) {
        return carbon_get_theme_option( $prefix.$key );
      });
    } else {
      // Return uncached value
      return carbon_get_theme_option( $prefix.$key );
    }

  }

  /**
    * Returns true if WP_ENV is anything other than 'development' or 'staging'.
    *   Useful for determining whether or not to enqueue a minified or non-
    *   minified script (which can be useful for debugging via browser).
    *
    * @return bool
    */
  public function is_production() {
    return ( !defined( 'WP_ENV' ) || ( defined('WP_ENV' ) && !in_array( WP_ENV, array('development', 'staging') ) ) );
  }

  /**
    * Returns true if request is via Ajax.
    *
    * @return bool
    */
  public function is_ajax() {
    return defined('DOING_AJAX') && DOING_AJAX;
  }

  /**
    * A wrapper for the plugin's data fiala prefix as defined in $settings
    *
    * @return string Prefix
    */
  public function prefix( $field_name = null ) {
    if( $field_name ) {
      return self::$prefix . $field_name;
    }
    return self::$prefix;
  }

/**
  * Wrapper for phpversion() and version_compare(), intended for legacy support.
  *
  * @return bool
  */
  public function is_php_version( $version = '5.3', $operator = '>=' ) {
    return version_compare( phpversion(), $version, $operator );
  }

  /**
    * Returns script ?ver= version based on environment (WP_ENV)
    *
    * If WP_ENV is not defined or equals anything other than 'development' or 'staging'
    * returns $script_version (if defined) else plugin verson. If WP_ENV is defined
    * as 'development' or 'staging', returns string representing file last modification
    * date (to discourage browser during development).
    *
    * @param string $script The filesystem path (relative to the script location of
    *    calling script) to return the version for.
    * @param string $script_version (optional) The version that will be returned if
    *    WP_ENV is defined as anything other than 'development' or 'staging'.
    *
    * @return string
    */
  public function get_script_version($script, $return_minified = false, $script_version = null) {
    $version = $script_version ?: self::$settings['data']['Version'];
    if($this->is_production()) return $version;

    $script = $this->get_script_path($script, $return_minified);
    if(file_exists($script)) {
      $version = date("ymd-Gis", filemtime( $script ) );
    }

    return $version;
  }

  /**
    * Returns script path or URL, either regular or minified (if exists).
    *
    * If in production mode or if @param $force_minify == true, inserts '.min' to the filename
    * (if exists), else return script name without (example: style.css vs style.min.css).
    *
    * @param string $script The relative (to the plugin folder) path to the script.
    * @param bool $return_minified If true and is_production() === true then will prefix the
    *   extension with .min. NB! Due to performance reasons, I did not include logic to check
    *   to see if the script_name.min.ext exists, so use only when you know it exists.
    * @param bool $return_url If true, returns full-qualified URL rather than filesystem path.
    *
    * @return string The URL or path to minified or regular $script.
    */
  public function get_script_path($script, $return_minified = false, $return_url = false) {
    $script = trim($script, '/');
    if($return_minified && strpos($script, '.') && $this->is_production()) {
      $script_parts = explode('.', $script);
      $script_extension = end($script_parts);
      array_pop($script_parts);
      $script = implode('.', $script_parts) . '.min.' . $script_extension;
    }

    return self::$settings[$return_url ? 'url' : 'path'] . $script;
  }

  /**
    * Returns absolute URL of $script.
    *
    * @param string $script The relative (to the plugin folder) path to the script.
    * @param bool
    */
  public function get_script_url($script, $return_minified = false) {
    return $this->get_script_path($script, $return_minified, true);
  }

}
