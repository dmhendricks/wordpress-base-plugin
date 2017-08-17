<?php
namespace VendorName\PluginName\PostTypes;
use VendorName\PluginName\Plugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use PostTypes\PostType;

class Clients extends Plugin {

  public function __construct() {

    // Sample Custom Post Type - Client
    add_action( 'carbon_fields_loaded', array( $this, 'add_post_type_client' ) );
    //$this->add_post_type_client();

    // Hide unnecessary publishing options like Draft, visibility, etc.
    add_action( 'admin_head-post.php', array( $this, 'hide_publishing_actions' ) );
    add_action( 'admin_head-post-new.php', array( $this, 'hide_publishing_actions' ) );

  }

  /**
    * Creates Client List (client) custom post type.
    *
    * @see https://github.com/jjgrainger/PostTypes PostTypes Reference
    * @since 0.1.0
    */
  public function add_post_type_client() {

    $options = array(
      'supports'            => array('title'),
      'labels'              => array(
        'menu_name' => 'Client List'
      ),
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_nav_menus'   => false,
      'rewrite'             => false,
      'has_archive'         => false
    );

    // Create new post type: client
    $cpt = new \PostTypes\PostType(
      array(
        'name' => 'client',
        'singular' => 'Client',
        'plural' => 'Clients',
        'slug' => 'client'
      ), $options
    );
    $cpt->icon('dashicons-star-filled');

    // Add fields
    Container::make( 'post_meta', __('Client Details', self::$textdomain ) )
      ->show_on_post_type( $cpt->postTypeName )
      ->add_fields( array(
        Field::make( 'text', $this->prefix( 'name' ), __( 'Name', self::$textdomain ) ),
        Field::make( 'text', $this->prefix( 'company' ), __( 'Company', self::$textdomain ) ),
      )
    );
    Container::make( 'post_meta', 'Contact Info' )
      ->show_on_post_type( $cpt->postTypeName )
      ->add_fields( array(
        Field::make( 'text', $this->prefix( 'url' ), __( 'Web Site', self::$textdomain ) ),
        Field::make( 'text', $this->prefix( 'phone' ), __( 'Phone Number', self::$textdomain ) ),
        Field::make( 'textarea', $this->prefix( 'address' ), __( 'Address', self::$textdomain ) )->set_rows( 4 )
      )
    );

  }

  /**
    * Remove unnecessary publishing actions as well as some some annoying
    *    third-party metaboxes (like Yoast SEO and the Visual Composer buttons,
    *    since we're not using the editor in this example)
    *
    * @since 0.1.0
    */
  public function hide_publishing_actions() {
    global $post;
    if( in_array($post->post_type, array('client')) ) {
      echo '<style type="text/css">
        #misc-publishing-actions,
        #minor-publishing-actions,
        #wpseo_meta,
        div.composer-switch {
          display:none;
        }
      </style>';
    }
  }

}
