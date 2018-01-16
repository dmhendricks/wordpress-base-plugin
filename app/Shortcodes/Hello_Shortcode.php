<?php
namespace VendorName\PluginName\Shortcodes;
use VendorName\PluginName\Plugin;

class Hello_Shortcode extends Plugin
{

  public function __construct() {

    // Usage: [hello name="Daniel"]
    if ( ! shortcode_exists( 'hello' ) ) {
        add_shortcode( 'hello', array( $this, 'hello_world_shortcode' ) );
    }

  }

  /**
   * A short code that returns "Hello {$name}!", if provided
   *
   * @param $atts array Shortcode Attributes
   * @return string Output of shortcode
   * @since 0.1.0
   */
  public function hello_world_shortcode( $atts ) {
    $atts = shortcode_atts( array(
      'name' => 'world'
    ), $atts, 'hello' );

    return sprintf( __( 'Hello %s!', self::$textdomain ), $atts[ 'name' ] );
  }

}
