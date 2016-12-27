<?php
namespace Nimbium\MyPlugin;

class Shortcodes {

    public function __construct()
    {
    	// Usage: [hello name="Daniel"]
        add_shortcode('hello', function($atts) {
        	return $this->hello_world($atts);
        });
    }

    private function hello_world( $atts ) {
		$atts = shortcode_atts(array(
			'name' => 'world'
		), $atts, 'hello');

		return 'Hello '.$atts['name'].'!';
    }

}
