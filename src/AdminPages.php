<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class AdminPages {

    protected $settings;

    public function __construct($_settings)
    {
        $this->settings = $_settings;
        $this->build();
    }

    public function build() {
        // Carbon Fields Docs: https://carbonfields.net/docs/containers-theme-options/

        Container::make('theme_options', $this->settings['data']['Name'])
            ->set_page_parent('options-general.php')
            ->add_tab(__('General'), array(
                Field::make('text', '_crb_email', 'Your E-mail Address')->help_text('Example help text.'),
                Field::make('text', '_crb_phone', 'Phone Number'),
                Field::make('date_time', '_crb_date_time', 'Date & Time'),
                Field::make('checkbox', '_crb_checkbox', 'Disable Haters')->set_option_value('yes'),
                Field::make('radio', '_crb_radio', 'Subtitle text style')
                    ->add_options(array(
                        'em' => 'Italic',
                        'strong' => 'Bold',
                        'del' => 'Strike',
                    )
                ),
                Field::make('complex', 'crb_slide')->add_fields(array(
                    Field::make('text', 'title'),
                    Field::make('image', 'photo'),
                )),
                Field::make("select", "_crb_select", "Best Music")
                    ->add_options(array(
                        'winning' => 'Matchbox Twenty',
                        'losing' => 'Nickelback',
                        'superstar' => 'Anything Armin van Buuren spins'
                    ))
                )
            )
            ->add_tab(__('Miscellaneous'), array(
                Field::make('color', '_crb_font_color'),
                Field::make('image', '_crb_default_image'),
                Field::make('file', '_crb_file', 'Non-Compete Agreement (PDF)')
            )

            /*
            // One page, no tabs
            ->add_fields(array(
                Field::make('color', 'crb_background_color'),
                Field::make('image', 'crb_background_image')
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
                Field::make('text', '_crb_meta_test')
            )
        );
        */

    }
}
