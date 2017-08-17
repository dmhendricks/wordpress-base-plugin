<?php
namespace VendorName\PluginName\Shortcodes;
use VendorName\PluginName\Plugin;

class HelloShortcode extends Plugin
{

  public function __construct() {

    // Usage: [hello name="Daniel"]
    if ( ! shortcode_exists( 'hello' ) ) {
        add_shortcode( 'hello', array( $this, 'hello_world' ) );
    }

  }

  /**
   * A short code the returns "Hello {$name}!", if provided
   *
   * @param $atts array Shortcode Attributes
   * @return string Output of shortcode
   * @since 0.1.0
   */
  public function hello_world( $atts ) {
    $atts = shortcode_atts( array(
      'name' => 'world'
    ), $atts, 'hello' );

    return sprintf( __( 'Hello', self::$textdomain ) . ' %s!', $atts[ 'name' ] );
  }

}
