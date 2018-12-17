<?php
namespace VendorName\PluginName\PostTypes;
use VendorName\PluginName\Plugin;

class PostTypes_Loader extends Plugin {

  /**
   * @var array Shortcode class name to register
   * @since 0.4.0
   */
  protected $posttypes;

  public function __construct() {

    $this->posttypes = array(
      Clients::class
    );

    foreach( $this->posttypes as $postTypesClass ) {
      if( class_exists( $postTypesClass ) ) new $postTypesClass();
    }

  }

}
