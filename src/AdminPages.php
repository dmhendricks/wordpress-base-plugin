<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class AdminPages extends Plugin {

    public static function create() {
        // Carbon Fields Docs: https://carbonfields.net/docs/containers-theme-options/

        Container::make('theme_options', parent::get_option('data')['Name'])
            ->set_page_parent('options-general.php')
            ->add_tab(__('General'), array(
                Field::make('text', parent::get_option().'email', 'Your E-mail Address')->help_text('Example help text.'),
                Field::make('text', parent::get_option().'phone', 'Phone Number'),
                Field::make('date_time', parent::get_option().'date_time', 'Date & Time'),
                Field::make('checkbox', parent::get_option().'checkbox', 'Disable New Registrations')->set_option_value(1)->set_default_value(1),
                Field::make('radio', parent::get_option().'radio', 'Subtitle text style')
                    ->add_options(array(
                        'em' => 'Italic',
                        'strong' => 'Bold',
                        'del' => 'Strike',
                    )
                ),
                Field::make('complex', parent::get_option().'slides')->add_fields(array(
                    Field::make('text', 'title'),
                    Field::make('image', 'photo'),
                )),
                Field::make("select", parent::get_option()."select", "Best Music")
                    ->add_options(array(
                        'winning' => 'Matchbox Twenty',
                        'losing' => 'Nickelback',
                        'superstar' => 'Anything Armin van Buuren spins'
                    ))
                )
            )
            ->add_tab(__('Miscellaneous'), array(
                Field::make('color', parent::get_option().'font_color', 'Foreground Color'),
                Field::make('image', parent::get_option().'default_image', 'Default Image'),
                Field::make('file', parent::get_option().'file', 'File Upload')
            )

            /*
            // One page, no tabs
            ->add_fields(array(
                Field::make('color', parent::get_option().'background_color', 'Background Color'),
                Field::make('image', parent::get_option().'background_image', 'Background Image')
            )
            */
        );

        // Add side metabox
        /*
        Container::make('post_meta', 'Custom Data')
            ->show_on_post_type('post')
            ->set_priority('default')
            ->set_context('side')
            ->add_fields(array(
                Field::make('text', parent::get_option().'meta_test')
            )
        );
        */

    }
}
