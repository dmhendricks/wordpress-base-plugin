<?php
namespace Nimbium\MyPlugin;

class Shortcodes extends Plugin {

    public static function create()
    {
        // Usage: [hello name="Daniel"]
        add_shortcode('hello', function($atts) {
          self::hello_world( $atts );
        });
    }

    private static function hello_world( $atts ) {
    		$atts = shortcode_atts(array(
    			'name' => 'world'
    		), $atts, 'hello');

    		return 'Hello '.$atts['name'].'!';
    }

}
