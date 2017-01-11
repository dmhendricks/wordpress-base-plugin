<?php
namespace Nimbium\MyPlugin;

class Plugin {

    public static $settings;

    public function __construct() { }

    public static function init($_settings) {
        self::$settings = $_settings;

        // Enqueue scripts
        EnqueueScripts::load();

        // Core plugin logic
        Core::load();

        // Deploy settings page(s)
        AdminPages::create();

        // Deploy custom meta boxes
        //MetaBoxes::create();

        // Deploy widgets
        //Widgets::create();

        // Deploy shortcodes
        //Shortcodes::create();

    }

    /*
    private function widgets() {

        add_action('widgets_init', function() {
            register_widget('Nimbium\MyPlugin\WidgetLoader');
        });
    }
    */

    public static function set_option($_value) {
      self::$settings = Helpers::array_merge_recursive_distinct(self::$settings, $_value);
    }

    public static function get_option($_key = 'prefix') {
      return self::$settings[$_key];
    }

}
