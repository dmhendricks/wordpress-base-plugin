<?php
namespace Nimbium\MyPlugin;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use PostTypes;

class CPT extends Plugin {

  public static function create()
  {

    // Sample Custom Post Type - Client
    self::CPT_client();

    // Hide unnecessary publishing options like Draft, visibility, etc.
    add_action('admin_head-post.php', array('Nimbium\MyPlugin\CPT', 'hide_publishing_actions'));
    add_action('admin_head-post-new.php', array('Nimbium\MyPlugin\CPT', 'hide_publishing_actions'));

  }


  private static function CPT_client() {
    // Reference: https://github.com/jjgrainger/PostTypes

    $options = [
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
    ];

    $cpt = new \PostTypes\PostType(
      array(
        'name' => parent::get_option().'client',
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
        Field::make('text', parent::get_option().'name', 'Name'),
        Field::make('text', parent::get_option().'company', 'Company'),
      )
    );

    Container::make('post_meta', 'Contact Info')
      ->show_on_post_type($cpt->postTypeName)
      ->add_fields(array(
        Field::make('text', parent::get_option().'url', 'Web Site'),
        Field::make('text', parent::get_option().'phone', 'Phone Number'),
        Field::make('textarea', parent::get_option().'address', "Services")->set_rows(4)
      )
    );

  }

  public static function hide_publishing_actions() {
    global $post;
    if( in_array($post->post_type, ['csm-project', 'csm-plugin']) ) {
      echo '<style type="text/css">
        #misc-publishing-actions,
        #minor-publishing-actions{
          display:none;
        }
      </style>';
    }
  }

}
