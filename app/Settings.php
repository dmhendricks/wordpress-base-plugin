<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Plugin {

  /**
    * Create a options/settings page in WP Admin
    */
  function __construct() {

    // Clear the cache when settings are saved
    add_action('carbon_fields_theme_options_container_saved', array( $this, 'options_saved_hook' ) );

    // Carbon Fields Docs: https://carbonfields.net/docs/containers-theme-options/
    Container::make('theme_options', self::$settings['data']['Name'])
      ->set_page_parent('options-general.php')
      ->add_tab(__('General'), array(
        Field::make('checkbox', self::$prefix.'remove_header_emojicons', 'Remove Emoji Code From Page Headers')
          ->help_text('Checking this box will remove the default Emoji code from page headers.'),
        Field::make( 'set', self::$prefix.'enqueue_font_awesome', __( 'Load Font Awesome from CDN', self::$textdomain))
          ->help_text('Load <a href="http://fontawesome.io/" target="_blank">Font Awesome</a> from <a href="https://www.bootstrapcdn.com/fontawesome/" target="_blank">CDN</a>.')
          ->add_options(array(
            'frontend' => 'Frontend',
            'backend' => 'Backend'
          ))
          ->set_default_value('backend'),
        Field::make( 'separator', self::$prefix.'general_separator_examples', __('Example Fields', self::$textdomain) )
          ->help_text('These fields are just provided as examples and are not used by any logic in the plugin.'),
        Field::make('text', self::$prefix.'blog_title', __('Blog Title', self::$textdomain)),
        Field::make('text', self::$prefix.'email', 'Your E-mail Address')
          ->set_attribute('type', 'email')
          ->help_text('This input field is an HTML5 <tt>email</tt> type.'),
        Field::make('text', self::$prefix.'web_site_url', 'Web Site Address')
          ->set_attribute('type', 'url')->set_attribute( 'placeholder', site_url() )
          ->help_text('This input field is an HTML5 <tt>url</tt> type.'),
        Field::make('text', self::$prefix.'phone', 'Phone Number')
          ->set_attribute('type', 'tel'),
        Field::make('date_time', self::$prefix.'date_time', 'Date & Time'),
        Field::make('radio', self::$prefix.'radio', 'Subtitle Font Style')
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

  /**
    * Logic that is run when settings are saved.
    */
  public function options_saved_hook() {

    // Clear the cache so that new settings are loaded
    Cache::flush();

  }

}
