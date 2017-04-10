<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class Widgets extends Plugin {

  function __construct() {}

  public static function create() {

    $self = self::get_instance();
    add_action('widgets_init', array(&$self, 'add_sample_widget'));

  }

  public static function add_sample_widget() {
    // https://carbonfields.net/docs/containers-widgets/

    register_widget(function() {
      $label = 'Plugin Widget - Example';

      $widget = \Carbon_Fields\Widget($label, $label);
      $widget->setup($label, 'Displays a block with title/text', array(
          Field::make('text', parent::get_option().'widget_title', 'Title')->set_default_value('Hello World!'),
          Field::make('textarea', parent::get_option().'widget_content', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
      ));

      // Called when rendering the widget in the front-end
      /*
      function front_end($args, $instance) {
          echo $args['before_title'] . $instance['title'] . $args['after_title'];
          echo '<p>' . $instance['content'] . '</p>';
      }
      */
    });

  }

  private static function get_instance() {
    return new self;
  }

}
