<?php
namespace Nimbium\MyPlugin;

class Plugin {

    public static $settings;

    public function __construct() { }

    public static function init($_settings) {
        self::$settings = $_settings;

        // Enqueue scripts
        //new EnqueueScripts();

        // Core plugin logic
        new Core();

        // Deploy settings page(s)
        new AdminPages();

        // Deploy custom meta boxes
        //new MetaBoxes();

        // Deploy widgets
        //new Widgets();

        // Deploy shortcodes
        //new Shortcodes();

    }

    /*
    private function widgets() {

        add_action('widgets_init', function() {
            register_widget('Nimbium\MyPlugin\WidgetLoader');
        });
    }
    */

    public static function set_option($_value) {
      //self::$settings = array_merge_recursive(self::$settings, $_value);
      self::$settings = Helpers::array_merge_recursive_distinct(self::$settings, $_value);

    }

    public static function get_option($_key = 'prefix') {
      return self::$settings[$_key];
    }

}
