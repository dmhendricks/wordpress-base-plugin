<?php
namespace VendorName\PluginName;
//use WordPress_ToolKit\ObjectCache;

class Core extends Plugin {

  function __construct() {

    // Example - Add page, post type and parent classes to <body> tag for selector targeting
    add_filter( 'body_class', array( &$this, 'add_body_classes' ) );

    // Example - Remove Emoji code from header
    if( $this->get_carbon_plugin_option( 'remove_header_emojicons' ) ) {
      if( !$this->is_ajax() ) add_filter( 'init', array( &$this, 'disable_wp_emojicons' ) );
    }

    // Multisite Example - Change WP Admin footer text
    if( is_multisite() && trim( $this->get_carbon_network_option( 'network_site_footer' ) ) ) {
      add_filter( 'admin_footer_text', array( &$this, 'set_admin_footer_text' ) );
    }

    /**
      * Example - Ajax call for when "Clear Cache" is clicked from the admin bar dropdown.
      *
      * Note: If this Ajax call was intended to be available to those who are not
      *    logged in, you would need to uncommend the 'wp_ajax_nopriv_clear_object_cache_ajax'
      *    hook.
      */
    if( current_user_can( 'manage_options' ) && $this->get_carbon_plugin_option( 'admin_bar_add_clear_cache' ) ) {
      add_action( 'admin_bar_menu', array( $this, 'admin_bar_add_clear_cache' ), 900 );
      //add_action( 'wp_ajax_nopriv_clear_object_cache_ajax', array( self::$cache, 'flush' ) );
      add_action( 'wp_ajax_clear_object_cache_ajax', array( self::$cache, 'flush' ) );
    }

  }

  /**
    * Returns string of addition CSS classes based on post type
    *
    * Returns CSS classes such as page-{slug}, parent-{slug}, post-type-{type} and
    *   category-{slug} for easier selector targeting
    *
    * @param array $classes An array of *current* body_class classes
    * @return array Modified array of body classes including new ones
    * @since 0.1.0
    */
  public function add_body_classes($classes) {
    $parent_slug = Helpers::get_parent_slug(true);
    $categories = is_single() ? Helpers::get_post_categories(true) : array();

    // Add page, parent and post-type classes, if available
    $classes[] = 'page-' . Helpers::get_page_slug();
    if( $parent_slug ) $classes[] = 'parent-' . $parent_slug;
    $classes[] = 'post-type-' . get_post_type();

    // Add category slugs
    foreach( $categories as $cat ) {
      $classes[] = 'category-' . $cat;
    }

    return $classes;
  }

  /**
    * Disabled Emojicons in page headers
    */
  public function disable_wp_emojicons() {

    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_filter( 'tiny_mce_plugins', function( $plugins) {
      return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : $plugins;
    });

  }

  /**
    * Set WP Admin footer text (multisite only)
    *
    * @param string Default footer text
    * @return string Modified footer text
    * @since 0.5.0
    */
  public function set_admin_footer_text( $footer_text ) {
    return trim( $this->get_carbon_network_option( 'network_site_footer' ) ) ?: $footer_text;
  }

  /**
    * Add "Clear Cache" link to admin bar dropdown
    * @since 0.3.0
    */
  public function admin_bar_add_clear_cache( $wp_admin_bar ) {

  	$args = array(
  		'id'     => 'clear_object_cache',
  		'title'	 =>	__( 'Clear Cache', self::$textdomain ),
      'parent' => 'site-name',
      'href'   => '#'
  	);
  	$wp_admin_bar->add_node( $args );

  }

  /**
    * Ajax handler for 'clear_object_cache_ajax' call.
    * @since 0.3.0
    */
  public function clear_object_cache_ajax() {

    $result = ['success' => true];

    try {
      self::$cache->flush();
    } catch (Exception $e) {
      $result = [ 'success' => false, 'message' => $e->getMessage() ];
    }

    echo json_encode( $result );
    wp_die();

  }

}
