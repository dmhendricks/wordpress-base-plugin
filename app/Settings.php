<?php
namespace VendorName\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Plugin {

  /**
    * Create a options/settings page in WP Admin
    */
  function __construct() {

    // Flush the cache when settings are saved
    add_action('carbon_fields_theme_options_container_saved', array( $this, 'options_saved_hook' ) );

    // Create tabbed plugin options page (Settings > Plugin Name)
    $this->create_tabbed_options_page();

  }

  /**
    * Create a tabbed options/settings page in WP Admin
    *
    * @see https://carbonfields.net/docs/containers-theme-options/ Carbon Fields Theme Options
    */
  private function create_tabbed_options_page() {

    // Carbon Fields Docs: https://carbonfields.net/docs/containers-theme-options/
    Container::make('theme_options', self::$settings['data']['Name'])
      ->set_page_parent('options-general.php')
      ->add_tab( __('General', self::$textdomain), array(
        Field::make('checkbox', $this->prefix('remove_header_emojicons'), __('Remove Emoji Code From Page Headers', self::$textdomain) )
          ->help_text( __('Checking this box will remove the default Emoji code from page headers.', self::$textdomain) ),
        Field::make( 'set', $this->prefix('enqueue_font_awesome'), __('Load Font Awesome from CDN', self::$textdomain) )
          ->help_text( __('Load <a href="http://fontawesome.io/" target="_blank">Font Awesome</a> from <a href="https://www.bootstrapcdn.com/fontawesome/" target="_blank">CDN</a>.', self::$textdomain) )
          ->add_options(array(
            'frontend' => __('Frontend', self::$textdomain),
            'backend' => __('Backend', self::$textdomain)
          ))
          ->set_default_value('backend'),
        Field::make( 'separator', $this->prefix('general_separator_examples'), __('Example Fields', self::$textdomain) )
          ->help_text( __('These fields are just provided as examples and are not used by any logic in the plugin.', self::$textdomain) ),
        Field::make('text', $this->prefix('blog_title'), __('Blog Title', self::$textdomain)),
        Field::make('text', $this->prefix('email'), __('Your E-mail Address', self::$textdomain) )
          ->set_attribute('type', 'email')
          ->help_text( __('This input field is an HTML5 <tt>email</tt> type.', self::$textdomain) ),
        Field::make('text', $this->prefix('web_site_url'), __('Web Site Address', self::$textdomain) )
          ->set_attribute('type', 'url')->set_attribute( 'placeholder', site_url() )
          ->help_text( __('This input field is an HTML5 <tt>url</tt> type.', self::$textdomain) ),
        Field::make('text', $this->prefix('phone'), __('Phone Number', self::$textdomain) )
          ->set_attribute('type', 'tel'),
        Field::make('date_time', $this->prefix('date_time'), __('Date & Time', self::$textdomain) ),
        Field::make('radio', $this->prefix('radio_buttons'), __('Menu Position', self::$textdomain))
          ->add_options(array(
            'none' => __('Disabled', self::$textdomain),
            'top' => __('Top (Default)', self::$textdomain),
            'left' => __('Left', self::$textdomain)
          ))
          ->set_default_value('top'),
        Field::make('complex', $this->prefix('slides'), self::$settings['data']['Name'] . ' ' . __('Slides', self::$textdomain))->add_fields(array(
          Field::make('text', 'title'),
          Field::make('image', 'photo'),
        )),
        Field::make('select', $this->prefix('select_dropdown'), __('Favorite Continent', self::$textdomain) )
          ->add_options(array(
            'aria' => __('Asia', self::$textdomain),
            'africa' => __('Africa', self::$textdomain),
            'europe' => __('Europe', self::$textdomain),
            'north-america' => __('North America', self::$textdomain),
            'south-america' => __('South America', self::$textdomain),
            'australia' => __('Australia', self::$textdomain),
            'antarctica' => __('Antarctica', self::$textdomain)
          ))
        )
      )
      ->add_tab( __('Miscellaneous', self::$textdomain), array(
        Field::make('color', $this->prefix('font_color'), __('Foreground Color', self::$textdomain) ),
        Field::make('image', $this->prefix('default_image'), __('Default Image', self::$textdomain) ),
        Field::make('file', $this->prefix('file'), __('File Upload', self::$textdomain) )
      )
    );

  }

  /**
    * Create a single options/settings page in WP Admin
    */
  private function create_single_options_page() {

    Container::make('theme_options', self::$settings['data']['Name'])
      ->set_page_parent('options-general.php')
      ->add_fields(array(
        Field::make('text', $this->prefix('your_name'), __('Your Name', self::$textdomain) ),
        Field::make('image', $this->prefix('profile_pic'), __('Profile Pic', self::$textdomain) )
      )
    );

  }

  /**
    * Logic that is run when settings are saved.
    */
  public function options_saved_hook() {

    // Clear the cache so that new settings are loaded
    Cache::flush();

  }

}
