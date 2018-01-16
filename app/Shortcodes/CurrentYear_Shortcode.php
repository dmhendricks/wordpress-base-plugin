<?php
namespace VendorName\PluginName\Shortcodes;
use VendorName\PluginName\Plugin;

class CurrentYear_Shortcode extends Plugin
{

  public function __construct() {

    // Usage: [current_year]
    if ( ! shortcode_exists( 'current_year' ) ) {
        add_shortcode( 'current_year', array( $this, 'current_year_shortcode' ) );
    }

  }

  /**
   * A short code that returns the current year
   *
   * @param $atts array Shortcode Attributes
   * @return string Output of shortcode
   * @since 0.4.0
   */
  public function current_year_shortcode( $atts ) {

    return date( 'Y' );

  }

}
