<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class WidgetLoader extends Widget {

    public function __construct()
    {
        $this->build();
    }

    public function build() {
        // https://carbonfields.net/docs/containers-widgets/

        $this->setup('Plugin Widget - Example', 'Displays a block with title/text', array(
            Field::make('text', 'title', 'Title')->set_default_value('Hello World!'),
            Field::make('textarea', 'content', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
        ));

        // Called when rendering the widget in the front-end
        function front_end($args, $instance) {
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
            echo '<p>' . $instance['content'] . '</p>';
        }

    }

}