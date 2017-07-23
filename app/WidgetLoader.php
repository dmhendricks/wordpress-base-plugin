<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class WidgetLoader extends Plugin {

  function __construct() {

    // Register widgets
    add_action( 'widgets_init', function() {
      register_widget( new My_Widget_Class() );
    });

  }

}

/**
  * A simply widget that displays a text field (title) and textarea.
  */
class My_Widget_Class extends Widget {

  function __construct() {

    $this->setup( WidgetLoader::$prefix . 'example_widget', __( 'Plugin Widget - Example', WidgetLoader::$textdomain ), 'Displays a block with title/text', array(
      Field::make( 'text', WidgetLoader::$prefix . 'widget_title', 'Title' )->set_default_value('Hello World!'),
      Field::make( 'textarea', WidgetLoader::$prefix . 'widget_content', 'Content' )->set_default_value('Lorem ipsum dolor sit amet')
    ), '');

  }

  // Called when rendering the widget in the front-end
  function front_end( $args, $instance ) {
    echo $args['before_title'] . $instance[WidgetLoader::$prefix . 'widget_title'] . $args['after_title'];
    echo '<p>' . $instance[WidgetLoader::$prefix.'widget_content'] . '</p>';
  }

}
