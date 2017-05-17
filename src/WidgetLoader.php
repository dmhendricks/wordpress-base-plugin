<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class WidgetLoader extends Plugin {

  function __construct() {

    // Register widgets
    add_action( 'widgets_init', function() {
      register_widget( new My_Widget_Class($this) );
    });

  }

}

class My_Widget_Class extends Widget {

  function __construct($loader) {

    $this->setup(__('Plugin Widget - Example'), 'Displays a block with title/text', array(
      Field::make('text', $loader::$prefix.'widget_title', 'Title')->set_default_value('Hello World!'),
      Field::make('textarea', $loader::$prefix.'widget_content', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
    ));

  }

  // Called when rendering the widget in the front-end
  function front_end($args, $instance) {
    echo $args['before_title'] . $instance['title'] . $args['after_title'];
    echo '<p>' . $instance['content'] . '</p>';
  }

}
