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

    /**
      * Add/update theme option in current settings array.
      *
      * Example usage:
      *     parent::set_option(['site_name' => 'My WordPress Site'])
      *
      * @param array $value An array of value(s) that you wish to merge into
      *     self::$settings array.
      *
      * @return bool
      */
    public static function set_option($values = array()) {
      if(!$values || !is_array($values)) return false;

      try {
        self::$settings = Helpers::array_merge_recursive_distinct(self::$settings, $values);
      } catch (Exception $e) {
        return false;
      }

      return true;
    }

    /**
      * Get single plugin setting defined in main plugin PHP loader (ex: wordpress-base-plugin.php)
      *
      * Example usage:
      *     parent::get_option()
      *       By default, returns self::$settings['prefix']
      *     parent::get_option('url')
      *       Returns self::$settings['url'])
      *     parent::get_option(['data', 'Version'])
      *       Returns self::$settings['data']['Version'])
      *
      * @param mixed $key The string key of array or an array path of keys.
      *
      * @return mixed Value of self::$settings array specified, if set
      */
    public static function get_option($key = array('prefix')) {
      if(!is_array($key)) $key = array($key);

      $return = self::$settings;

      try {
        foreach($key as $idx) {
          $return = $return[$idx];
        }
      } catch (Exception $e) {
        return null;
      }

      return $return;
    }

    /**
      * Return all plugin settings defined in main plugin PHP loader (ex: wordpress-base-plugin.php)
      *
      * @return array Current plugin settings
      */
    public static function get_options() {
      return self::$settings;
    }

}
