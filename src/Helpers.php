<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Helpers {

    protected $settings;

    public function __construct($_settings)
    {
        $this->settings = $_settings;
    }

    public static function get_page_slug($post_id = null) {
        global $post;
        return $post_id ? get_post($post_id)->post_name : $post->post_name;
    }

}
