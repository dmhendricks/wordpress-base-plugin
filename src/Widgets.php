<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class Widgets extends Page {

    public static function create() {
        $this->add_sample_widget();
    }

    private static function add_sample_widget() {
        // https://carbonfields.net/docs/containers-widgets/

        $this->setup('Plugin Widget - Example', 'Displays a block with title/text', array(
            Field::make('text', parent::get_option().'widget_title', 'Title')->set_default_value('Hello World!'),
            Field::make('textarea', parent::get_option().'widget_content', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
        ));

        // Called when rendering the widget in the front-end
        function front_end($args, $instance) {
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
            echo '<p>' . $instance['content'] . '</p>';
        }

    }

}
