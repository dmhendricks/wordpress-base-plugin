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

    // Enqueue admin scripts
    private static function enqueue_frontend_scripts() {

      wp_enqueue_style( 'custom-style', plugins_url('/assets/css/site.css', dirname(__FILE__)), array('parent-style'), self::get_script_modified_version('../assets/css/site.css') );

    }

    // Enqueue admin scripts
    private static function enqueue_admin_scripts() {

        // Only load script(s) on edit pages
        if( strstr($_SERVER['REQUEST_URI'], '/post-new.php') || strstr($_SERVER['REQUEST_URI'], '/post.php') ) {

        	add_action( 'admin_enqueue_scripts', function() {

                // Load custom JavaScript in admin
                wp_enqueue_style( 'wordpress-base-plugin', plugins_url('/assets/js/wordpress-base-admin.js', dirname(__FILE__)) );

        	});

        }

    }

    private static function get_script_modified_version($script) {
      if(!defined('WP_ENV')) return parent::get_option('data')['Version'];
      return WP_ENV == 'production' ? parent::get_option('data')['Version'] : date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . $script ));
    }

}
