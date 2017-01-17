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

    /**
      * Merges two array, eliminating duplicates
      *
      * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
      * Matching keys' values in the second array overwrite those in the first array, as is the
      * case with array_merge().
      *
      * @param array array1
      * @param array array2
      * @return array
      * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
      * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
      */
    public static function array_merge_recursive_distinct( array &$array1, array &$array2 ) {
      // Credit: http://php.net/manual/en/function.array-merge-recursive.php#92195
      $merged = $array1;

      foreach ( $array2 as $key => &$value )
      {
        if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) ) {
          $merged [$key] = self::array_merge_recursive_distinct ( $merged [$key], $value );
        } else {
          $merged [$key] = $value;
        }
      }

      return $merged;
    }

}
