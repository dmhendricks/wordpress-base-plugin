<?php
namespace Nimbium\MyPlugin;

class EnqueueScripts extends Plugin {

  function __construct() {

    // Enqueue frontend and backend scripts
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts') );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts') );

    // Load Font Awesome from CDN, if enabled
    $enqueue_font_awesome = carbon_get_theme_option( self::$prefix.'enqueue_font_awesome' );
    if( $enqueue_font_awesome ) {
      if( in_array( 'frontend', $enqueue_font_awesome) )
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_font_awesome') );
      if( in_array( 'backend', $enqueue_font_awesome) )
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_font_awesome') );
    }

  }

  /**
    * Enqueue scripts used on frontend of site
    */
  public function enqueue_frontend_scripts() {

    // Example enqueuing remote scripts (http://select2.github.io/)
    wp_enqueue_style( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', null, '4.0.3' );
    wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), '4.0.3' );

    // Example enqueuing a script added from ZIP file via composer (http://underscorejs.org/)
    wp_enqueue_script( 'underscore', $this->get_script_url('vendor/jashkenas/underscore/underscore-min.js'), null, '1.8.3' );

    // Enqueuing custom CSS for child theme (Twentysixteen was used for testing)
    wp_enqueue_style( 'child-style', $this->get_script_url('assets/css/site.css'), array('select2'), $this->get_script_version('assets/css/site.css') );

  }

  /**
    * Enqueue scripts used in WP admin interface
    */
  public function enqueue_admin_scripts() {

    wp_enqueue_script( 'wordpress-base-plugin', $this->get_script_url('assets/js/wordpress-base-admin.js'), array('jquery'), $this->get_script_version('assets/js/wordpress-base-admin.js')  );

  }

  /**
    * Enqueue Font Awesome
    */
  public function enqueue_font_awesome() {

    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, '4.7.0' );

  }

}
