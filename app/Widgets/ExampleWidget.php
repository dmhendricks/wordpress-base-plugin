<?php
namespace VendorName\PluginName\Widgets;
use VendorName\PluginName\Plugin;
use Carbon_Fields\Field;
use Carbon_Fields\Widget;

/**
 * A simple widget that displays a text field (title) and textarea.
 * @since 0.3.0
 */
class ExampleWidget extends Widget {

  public function __construct() {

    $this->setup( Plugin::prefix( 'example_widget' ), __( 'Plugin Widget - Example', Plugin::$textdomain ),
      __( 'Displays a block with title/text', Plugin::$textdomain ), array(
        Field::make( 'text', Plugin::prefix( 'widget_title' ), __( 'Title', Plugin::$textdomain ) )
          ->set_default_value( 'Hello World!' ),
        Field::make( 'textarea', Plugin::prefix( 'widget_content' ), __( 'Content', Plugin::$textdomain ) )
          ->set_default_value( 'Lorem Ipsum dolor sit amet' )
      )
    );

  }

  /**
   * A simple widget that displays a text field (title) and textarea.
   * @since 0.3.0
   */
  public function front_end( $args, $instance ) {

    echo $args['before_title'] . $instance[$this->prefix( 'widget_title' )] . $args['after_title'];
    echo '<p>' . $instance[$this->prefix( 'widget_content')] . '</p>';

  }

}
