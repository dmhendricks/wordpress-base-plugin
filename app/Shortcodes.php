<?php
namespace VendorName\MyPlugin;

class Shortcodes extends Plugin {

  function __construct() {

    // Usage: [hello name="Daniel"]
    if( !shortcode_exists( 'hello' ) ) {
      add_shortcode( 'hello', array( $this, 'hello_world' ) );
    }

  }

  /**
    * A short code the returns "Hello {$name}!", if provided
    *
    * @since 0.1.0
    */
  public static function hello_world( $atts ) {
		$atts = shortcode_atts(array(
			'name' => 'world'
		), $atts, 'hello');

		return 'Hello ' . $atts['name'] . '!';
  }

}
