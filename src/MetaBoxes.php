<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class MetaBoxes {

    protected $settings;

    public function __construct($_settings)
    {
        $this->settings = $_settings;
        $this->build();
    }

    public function build() {
        Container::make('post_meta', 'Sample Meta Box')
            ->show_on_post_type('post')
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(array(
                Field::make("set", "_practice_areas", '')
                    ->add_options(array("Option 1", "Option 2", "Option 3"))
            ));
    }

}
