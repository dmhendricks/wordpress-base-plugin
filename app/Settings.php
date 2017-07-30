<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Plugin {

  /**
    * Create a options/settings page in WP Admin
    */
  function __construct() {
    // Carbon Fields Docs: https://carbonfields.net/docs/containers-theme-options/

    Container::make('theme_options', self::$settings['data']['Name'])
      ->set_page_parent('options-general.php')
      ->add_tab(__('General'), array(
        Field::make('text', self::$prefix.'front_page_title', 'Front Page Title Tag')
          ->help_text('Setting this will override the <tt>&lt;title&gt;</tt> tag on the front page.'),
        Field::make('text', self::$prefix.'email', 'Your E-mail Address')
          ->set_attribute('type', 'email')
          ->help_text('This input is an HTML5 <tt>email</tt> type.'),
        Field::make('text', self::$prefix.'phone', 'Phone Number')
          ->set_attribute('type', 'tel'),
        Field::make('date_time', self::$prefix.'date_time', 'Date & Time'),
        Field::make('checkbox', self::$prefix.'checkbox', 'Disable New Registrations')->set_option_value(1)->set_default_value(1),
        Field::make('radio', self::$prefix.'radio', 'Subtitle text style')
          ->add_options(array(
            'em' => 'Italic',
            'strong' => 'Bold',
            'del' => 'Strike',
          )
        ),
        Field::make('complex', self::$prefix.'slides', self::$settings['data']['Name'] . ' ' . __('Slides', self::$textdomain))->add_fields(array(
          Field::make('text', 'title'),
          Field::make('image', 'photo'),
        )),
        Field::make("select", self::$prefix."select", "Best Music")
          ->add_options(array(
            'winning' => 'Andy Grammer',
            'losing' => 'Nickelback',
            'superstar' => 'Anything Armin van Buuren spins'
          ))
        )
      )
      ->add_tab(__('Miscellaneous'), array(
        Field::make('color', self::$prefix.'font_color', 'Foreground Color'),
        Field::make('image', self::$prefix.'default_image', 'Default Image'),
        Field::make('file', self::$prefix.'file', 'File Upload')
      )

      /*
      // One page, no tabs (Example)
      ->add_fields(array(
        Field::make('color', self::$prefix.'background_color', 'Background Color'),
        Field::make('image', self::$prefix.'background_image', 'Background Image')
      )
      */
    );

    // Add side metabox (Example)
    /*
    Container::make('post_meta', 'Custom Data')
      ->show_on_post_type('post')
      ->set_priority('default')
      ->set_context('side')
      ->add_fields(array(
        Field::make('text', self::$prefix.'meta_test')
      )
    );
    */

  }

}
