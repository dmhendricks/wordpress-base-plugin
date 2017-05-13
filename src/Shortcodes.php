<?php
namespace Nimbium\MyPlugin;

class Shortcodes extends Plugin {

  function __construct() {

    // Usage: [hello name="Daniel"]
    if(!shortcode_exists('hello')) {
      add_shortcode('hello', array(&$this, 'hello_world'));
    }

  }

  private static function hello_world( $atts ) {
		$atts = shortcode_atts(array(
			'name' => 'world'
		), $atts, 'hello');

		return 'Hello '.$atts['name'].'!';
  }

}
