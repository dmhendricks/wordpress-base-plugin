<?php
namespace Nimbium\MyPlugin;

class Plugin {

    public $settings;

    public function __construct($_settings)
    {
        $this->settings = $_settings;
        $this->init();
    }

    private function init() {
        // Enqueue scripts
        //$this->enqueue_scripts();

        // Enqueue scripts
        $this->overrides();

        // Deploy settings page(s)
        $this->admin_pages();

        // Deploy custom meta boxes
        $this->meta_boxes();

        // Deploy widgets
        //$this->widgets();

        // Deploy shortcodes
        $this->shortcodes();

    }

    private function enqueue_scripts() {
        return new \Nimbium\MyPlugin\EnqueueScripts($this->settings);
    }

    private function overrides() {
        return new \Nimbium\MyPlugin\Overrides($this->settings);
    }

    private function admin_pages() {
        return new \Nimbium\MyPlugin\AdminPages($this->settings);
    }

    private function meta_boxes() {
        return new \Nimbium\MyPlugin\MetaBoxes($this->settings);
    }

    private function widgets() {
        // [TODO]
        /*
        add_action('widgets_init', function() {
            register_widget('Nimbium\MyPlugin\WidgetLoader');
        });
        */
    }

    private function shortcodes() {
        return new \Nimbium\MyPlugin\Shortcodes($this->settings);
    }

    /*
    public static function get_plugin_config() {
        return $this->settings;
    }
    */

}
