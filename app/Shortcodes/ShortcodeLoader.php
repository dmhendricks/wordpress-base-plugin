<?php
namespace VendorName\PluginName\Shortcodes;
use VendorName\PluginName\Plugin;

class ShortcodeLoader extends Plugin {

  /**
   * @var array Shortcode class name to register
   * @since 0.3.0
   */
  protected $shortcodes;

  public function __construct() {

    $this->shortcodes = array(
      HelloShortcode::class
    );

    foreach( $this->shortcodes as $shortcodeClass ) {

      $shortcode = new $shortcodeClass();
      if( $shortcode instanceof ShortcodeInterface ) {
          new $shortcode();
      } else {
          // You could log not added shortcodes here
      }

    }

  }

}
