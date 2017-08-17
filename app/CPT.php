<?php
namespace VendorName\PluginName;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use PostTypes;

class CPT extends Plugin {

  function __construct() {

    // Sample Custom Post Type - Client
    $this->add_post_type_client();

    // Hide unnecessary publishing options like Draft, visibility, etc.
    add_action( 'admin_head-post.php', array( $this, 'hide_publishing_actions' ) );
    add_action( 'admin_head-post-new.php', array( $this, 'hide_publishing_actions' ) );

  }

  private function add_post_type_client() {
    // Reference: https://github.com/jjgrainger/PostTypes

    $options = array(
      'supports' => array('title'),
      'labels' => array(
        'menu_name' => 'Client List'
      ),
      'exclude_from_search' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_nav_menus' => false,
      'rewrite' => false,
      'has_archive' => false
    );

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
    Container::make('post_meta', 'Client Details')
      ->show_on_post_type($cpt->postTypeName)
      ->add_fields(array(
        Field::make('text', $this->prefix( 'name' ), 'Name'),
        Field::make('text', $this->prefix( 'company' ), 'Company'),
      )
    );

    Container::make('post_meta', 'Contact Info')
      ->show_on_post_type($cpt->postTypeName)
      ->add_fields(array(
        Field::make('text', $this->prefix( 'url' ), 'Web Site'),
        Field::make('text', $this->prefix( 'phone' ), 'Phone Number'),
        Field::make('textarea', $this->prefix( 'address' ), 'Services')->set_rows(4)
      )
    );

  }

  public function hide_publishing_actions() {
    global $post;
    if( in_array($post->post_type, array('client')) ) {
      echo '<style type="text/css">
        #misc-publishing-actions,
        #minor-publishing-actions{
          display:none;
        }
      </style>';
    }
  }

}
