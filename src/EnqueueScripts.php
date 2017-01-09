<?php
namespace Nimbium\MyPlugin;

class EnqueueScripts extends Plugin {

    public function __construct()
    {
        $this->enqueue_admin_scripts();
    }

    // Enqueue admin scripts
    public function enqueue_admin_scripts() {

        // Only load script(s) on edit pages
        if( strstr($_SERVER['REQUEST_URI'], '/post-new.php') || strstr($_SERVER['REQUEST_URI'], '/post.php') ) {

        	add_action( 'admin_enqueue_scripts', function() {

                // Load custom JavaScript in admin
                wp_enqueue_style( 'wordpress-base-plugin', plugins_url('/assets/js/wordpress-base-plugin.js', dirname(__FILE__)) );

        	});

        }

    }

}
