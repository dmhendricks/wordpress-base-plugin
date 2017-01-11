<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class MetaBoxes extends Plugin {

    public static function create {
        $this->build_sample_meta_box();
    }

    private static function build_sample_meta_box() {

        Container::make('post_meta', 'Sample Meta Box')
            ->show_on_post_type('post')
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(array(
                Field::make('set', parent::get_option().'option_set', 'Make Choices')
                    ->add_options(array("Option 1", "Option 2", "Option 3"))
            ));

    }

}
