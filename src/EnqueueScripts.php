<?php
namespace Nimbium\MyPlugin;

class EnqueueScripts extends Plugin {

    public static function load()
    {
        add_action( 'wp_loaded', function() {
          self::enqueue_frontend_scripts();
          self::enqueue_admin_scripts();
        });
    }

    /**
      * Enqueue scripts used on frontend of site
      */
    private static function enqueue_frontend_scripts() {

      // Example enqueuing remote scripts (http://select2.github.io/)
      wp_enqueue_style( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', false, '4.0.3' );
      wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), self::get_script_modified_version('../assets/css/site.css', '1.8.3') );

      // Example enqueuing a script added from ZIP file via composer (http://underscorejs.org/)
      wp_enqueue_script( 'underscore', plugins_url('/vendor/jashkenas/underscore/underscore-min.js', dirname(__FILE__)), false, '1.8.3' );

      // Enqueuing custom CSS for child theme (Twentysixteen was used for testing)
      wp_enqueue_style( 'child-style', plugins_url('/assets/css/site.css', dirname(__FILE__)), array('parent-style', 'select2'), self::get_script_modified_version('../assets/css/site.css') );
      wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), self::get_script_modified_version('../assets/css/site.css', '1.8.3') );
    }

    /**
      * Enqueue scripts used in WP admin interface
      */
    private static function enqueue_admin_scripts() {

        // Only load script(s) on edit pages
        if( strstr($_SERVER['REQUEST_URI'], '/post-new.php') || strstr($_SERVER['REQUEST_URI'], '/post.php') ) {

        	add_action( 'admin_enqueue_scripts', function() {

                // Load custom JavaScript in admin
                wp_enqueue_script( 'wordpress-base-plugin', plugins_url('/assets/js/wordpress-base-admin.js', dirname(__FILE__)) );

        	});

        }

    }

    /**
      * Returns script ?ver= version based on environment (WP_ENV)
      *
      * If WP_ENV == 'production', returns @param string $script_version (if specified),
      * else, returns $plugin_version, else if WP_ENV is equal to anything else, returns
      * string representing file last modified change (to prevent caching during development).
      *
      * @param string $script The filesystem path (relative to the script location of calling
      *    script) to return the version for.
      * @param string $script_version (optional) The version that will be returned if
      *    WP_ENV == 'production'. If not specified, plugin version will be used.
      *
      * @return string
      */
    private static function get_script_modified_version($script, $script_version = null) {
      $plugin_version = parent::get_option('data')['Version'];
      if(!defined('WP_ENV')) return $plugin_version;

      try {
        $script_version = in_array(WP_ENV, ['production', 'live']) ? ($script_version ? $script_version : $plugin_version) : date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . $script ));
      } catch (Exception $e) {
        $script_version = $plugin_version;
      }

      return $script_version;
    }

}
