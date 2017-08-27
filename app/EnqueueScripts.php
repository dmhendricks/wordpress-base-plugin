<?php
namespace VendorName\PluginName;

class EnqueueScripts extends Plugin {

  function __construct() {

    // TODO: Put back font awesome

    // Enqueue frontend/backend scripts and global JavaScript variables
    add_action( 'wp_head', array( $this, 'inject_javascript_settings' ) );
    add_action( 'admin_head', array( $this, 'inject_javascript_settings' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts') );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts') );

    // Example - Load Font Awesome from CDN, if enabled in Settings Page
    $enqueue_font_awesome = $this->get_plugin_option( 'enqueue_font_awesome' );
    if( $enqueue_font_awesome ) {
      if( in_array( 'frontend', $enqueue_font_awesome) )
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_font_awesome') );
      if( in_array( 'backend', $enqueue_font_awesome) )
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_font_awesome') );
    }

  }

  /**
    * Enqueue scripts used on frontend of site
    * @since 0.1.0
    */
  public function enqueue_frontend_scripts() {

    // Enqueue script dependencies
    $this->enqueue_bower_scripts();

    // Enqueuing custom CSS for child theme (Twentysixteen was used for testing)
    wp_enqueue_style( 'wordpress-base-plugin', $this->get_script_url('assets/css/wordpress-base-plugin.css'), null, $this->get_script_version('assets/css/wordpress-base-plugin.css') );

    // Enqueue frontend JavaScript
    wp_enqueue_script( 'wordpress-base-plugin', $this->get_script_url('assets/js/wordpress-base-plugin.js'), array('jquery', 'jquery-waituntilexists'), $this->get_script_version('assets/js/wordpress-base-plugin.js'), true );
    wp_localize_script( 'wordpress-base-plugin', 'wpbp_ajax_filter_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  }

  /**
    * Enqueue scripts used in WP admin interface
    * @since 0.1.0
    */
  public function enqueue_admin_scripts() {

    // Enqueue script dependencies
    $this->enqueue_bower_scripts();

    // Enqueuing custom CSS for child theme (Twentysixteen was used for testing)
    wp_enqueue_style( 'wordpress-base-plugin', $this->get_script_url('assets/css/wordpress-base-plugin-admin.css'), null, $this->get_script_version('assets/css/wordpress-base-plugin-admin.css') );

    // Enqueue WP Admin JavaScript
    wp_enqueue_script( 'wordpress-base-plugin-admin', $this->get_script_url('assets/js/wordpress-base-plugin-admin.js'), array('jquery', 'jquery-waituntilexists'), $this->get_script_version('assets/js/wordpress-base-plugin-admin.js'), true );
    wp_localize_script( 'wordpress-base-plugin-admin', 'wpbp_ajax_filter_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  }

  /**
    * Enqueue Bower components from assets/components
    * @since 0.3.0
    */
  private function enqueue_bower_scripts() {

    // Enqueue common (frontend/backend) JavaScript
    wp_enqueue_script( 'jquery-waituntilexists', $this->get_script_url('assets/components/jq.waituntilexists/jquery.waitUntilExists.min.js', false), array('jquery'), '0.1.0' );

  }

  /**
    * Enqueue Font Awesome
    * @since 0.1.0
    */
  public function enqueue_font_awesome() {

    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, '4.7.0', true );

  }

  /**
    * Add global JavaScript settings variables. You can add any variables/settings
    *    that you want to make available to your JavaScripts
    * @since 0.3.0
    */
  public function inject_javascript_settings() {

    $javascript_variables = array(
      'admin_bar_add_clear_cache' => $this->get_plugin_option( 'admin_bar_add_clear_cache' ),
      'admin_bar_add_clear_cache_success' => __( 'WordPress cache has been cleared.', self::$textdomain ),
      'show_clear_cache_link' => current_user_can( 'manage_options' )
    );

    echo "<script>var _wpbp_plugin_settings = JSON.parse('" . json_encode( $javascript_variables ) . "');</script>";

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
    * @since 0.1.0
    */
  public function get_script_version($script, $return_minified = false, $script_version = null) {
    $version = $script_version ?: self::$config->get( 'plugin/meta/Version' );
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
    * @since 0.1.0
    */
  public function get_script_path($script, $return_minified = true, $return_url = false) {
    $script = trim($script, '/');
    if($return_minified && strpos($script, '.') && $this->is_production()) {
      $script_parts = explode('.', $script);
      $script_extension = end($script_parts);
      array_pop($script_parts);
      $script = implode('.', $script_parts) . '.min.' . $script_extension;
    }

    return self::$config->get( $return_url ? 'plugin/url' : 'plugin/path' ) . $script;
  }

  /**
    * Returns absolute URL of $script.
    *
    * @param string $script The relative (to the plugin folder) path to the script.
    * @param bool
    * @since 0.1.0
    */
  public function get_script_url($script, $return_minified = false) {
    return $this->get_script_path($script, $return_minified, true);
  }

}
