<?php
namespace Nimbium\MyPlugin;

class Plugin {

  public static $settings;
  public static $textdomain;
  public static $prefix;

  function __construct($_settings) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['textdomain'];
    self::$prefix     = $_settings['prefix'].(is_multisite() && defined('TMC_SITE_ID') ? TMC_SITE_ID.'_' : '');

    self::$settings = $_settings;

    // Enqueue scripts
    new EnqueueScripts();

    // Core plugin logic
    new Core();

    // Deploy settings page(s)
    new Settings();

    // Create Custom Post Type(s)
    // CPT::create();

    // Deploy custom meta boxes
    // MetaBoxes::create();

    // Deploy widgets
    // $widgets = new Widgets();
    // Widgets::create();

    // Deploy shortcodes
    // Shortcodes::create();

  }

  /**
    * Returns true if WP_ENV is anything other than 'development' or 'staging'
    *
    * @return bool
    */
  public function is_production() {
    if( !defined('WP_ENV') ) {
      return true;
    } else {
      return !in_array(WP_ENV, ['development', 'staging']);
    }
  }

  /**
    * Returns true if request is via Ajax
    *
    * @return bool
    */
  public function is_ajax() {
    return defined('DOING_AJAX') && DOING_AJAX;
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
    * @param bool $enable_minify Enables checking for minified version and returning that instead
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
    * Returns absolute script url
    */
  public function get_script_url($script, $return_minified = false) {
    return $this->get_script_path($script, $return_minified, true);
  }

  /**
    * Merges two array, eliminating duplicates
    *
    * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
    * Matching keys' values in the second array overwrite those in the first array, as is the
    * case with array_merge().
    *
    * @param array $array1
    * @param array $array2
    * @return array
    * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
    * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
    */
  private function array_merge_recursive_distinct( array &$array1, array &$array2 ) {
    // Credit: http://php.net/manual/en/function.array-merge-recursive.php#92195
    $merged = $array1;

    foreach ( $array2 as $key => &$value )
    {
      if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) ) {
        $merged [$key] = self::array_merge_recursive_distinct ( $merged [$key], $value );
      } else {
        $merged [$key] = $value;
      }
    }

    return $merged;
  }

}
