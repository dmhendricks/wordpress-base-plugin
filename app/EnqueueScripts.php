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
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_font_awesome' ) );
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
    wp_enqueue_style( 'wordpress-base-plugin', Helpers::get_script_url( 'assets/css/wordpress-base-plugin.css' ), null, Helpers::get_script_version( 'assets/css/wordpress-base-plugin.css' ) );

    // Enqueue frontend JavaScript
    wp_enqueue_script( 'wordpress-base-plugin', Helpers::get_script_url( 'assets/js/wordpress-base-plugin.js' ), array( 'jquery', 'jquery-waituntilexists' ), Helpers::get_script_version( 'assets/js/wordpress-base-plugin.js' ), true );
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
    wp_enqueue_style( 'wordpress-base-plugin', Helpers::get_script_url( 'assets/css/wordpress-base-plugin-admin.css' ), null, Helpers::get_script_version( 'assets/css/wordpress-base-plugin-admin.css' ) );

    // Enqueue WP Admin JavaScript
    wp_enqueue_script( 'wordpress-base-plugin-admin', Helpers::get_script_url( 'assets/js/wordpress-base-plugin-admin.js' ), array('jquery', 'jquery-waituntilexists'), Helpers::get_script_version( 'assets/js/wordpress-base-plugin-admin.js' ), true );
    wp_localize_script( 'wordpress-base-plugin-admin', 'wpbp_ajax_filter_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  }

  /**
    * Enqueue Bower components from assets/components
    * @since 0.3.0
    */
  private function enqueue_bower_scripts() {

    // Enqueue common (frontend/backend) JavaScript
    wp_enqueue_script( 'jquery-waituntilexists', Helpers::get_script_url( 'assets/components/jq.waituntilexists/jquery.waitUntilExists.min.js', false ), array( 'jquery' ), '0.1.0' );

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

}
