<?php
namespace Nimbium\MyPlugin;

class Plugin {

    protected $settings;

    public function __construct($_settings)
    {
        $this->settings = $_settings;
        $this->init();
    }

    private function init() { 
        // Deploy settings page(s)
        $this->admin_pages();

        // Deploy widgets
        $this->widgets();

        // Deploy shortcodes
        $this->shortcodes();

    }

    private function admin_pages() {
        return new \Nimbium\MyPlugin\AdminPages($this->settings);
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

}
