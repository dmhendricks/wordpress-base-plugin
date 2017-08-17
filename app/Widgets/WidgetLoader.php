<?php
namespace VendorName\PluginName\Widgets;
use VendorName\PluginName\Plugin;

class WidgetLoader extends Plugin {

  public function __construct() {

    // Register widgets
    add_action( 'widgets_init', function () {
      register_widget( new ExampleWidget() );
    } );

  }

}
