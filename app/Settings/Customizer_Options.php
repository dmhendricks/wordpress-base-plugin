<?php
namespace VendorName\PluginName\Settings;
use VendorName\PluginName\Plugin;
use Inc2734\WP_Customizer_Framework\Customizer_Framework;
use WordPress_ToolKit\Helpers\StringHelper;

/**
  * Add custom section to Customizer
  *
  * @link https://github.com/inc2734/wp-customizer-framework
  * @since 0.4.0
  */
class Customizer_Options extends Plugin {

  protected $customizer;

  function __construct() {

    // Create a default section name based on the plugin's slug
    $slug = StringHelper::underscores( self::$config->get( 'plugin/slug' ) );

    // Define Customizer sections and fields
    $this->customizer = Customizer_Framework::init();

    // Add new panel
    $panel = $this->customizer->panel( $this->prefix( $slug ) . '_panel', [
      'title' => self::$config->get( 'plugin/meta/Name' )
    ]);

    // Add new section
    $section = $this->customizer->section( $this->prefix( 'my-plugin-section' ), [
      'title' => __( 'My Plugin Section', self::$textdomain ),
      'description' => __( 'Example Customizer Section', self::$textdomain )
    ]);

    // Define fields
    $controls = [
      $this->customizer->control( 'file', $this->prefix( 'favicon' ), [
        'label'   => __( 'Favicon', self::$textdomain ),
        //'default' => get_home_url( null, 'favicon.ico' )
      ]),
      $this->customizer->control( 'color', $this->prefix( 'hyperlink-color' ), [
        'label'   => __( 'Hyperlink Color', self::$textdomain ),
        'default' => '#007acc'
      ]),
      $this->customizer->control( 'checkbox', $this->prefix( 'hyperlink-underline' ), [
        'label'   => __( 'Underline Hyperlinks', self::$textdomain ),
        'default' => false,
        'description' => __( 'Add underline to hyperlinks.', self::$textdomain )
      ]),
      $this->customizer->control( 'color', $this->prefix( 'h2-color' ), [
        'label'   => __( 'H2 Header Color', self::$textdomain ),
        'default' => '#1A1A1A'
      ])
    ];

    // Add panel with section and fields
    foreach( $controls as $control ) {
      $control->join( $section )->join( $panel );
    }

    // Initialize Customizer options
    add_action( 'wp_loaded', array( $this, 'init_customizer_options' ) );

    // Inject favicon link into page head
    add_action( 'wp_head', array( $this, 'inject_customizer_options'), 1 );

  }

  /**
    * Initialize Customizer option sections and fields
    * @since 0.4.0
    */
  public function init_customizer_options() {

    $cfs = $this->customizer->styles();

    // Inject hyperlink style
    $hyperlink_color = get_theme_mod( $this->prefix( 'hyperlink-color' ) );
    $hyperlink_underline = get_theme_mod( $this->prefix( 'hyperlink-underline' ) ) ? 'underline' : 'none';

    $cfs->register([
        'a' // CSS selector
      ],
      [
        "color: {$hyperlink_color}",
        "text-decoration: {$hyperlink_underline}",
      ]
      //,'@media (min-width: 768px)' // Optional
    );

    // Inject H2 color style
    $h2_color = get_theme_mod( $this->prefix( 'h2-color' ) );

    $cfs->register([
        'h2' // CSS selector
      ],
      [
        "color: {$h2_color}"
      ]
    );

  }

  /**
    * Add relevant Customizer options to page head
    * @since 0.4.0
    */
  public function inject_customizer_options() {

    $favicon = get_theme_mod( $this->prefix( 'favicon' ) );
    if( !$favicon ) return;
    $file_type = wp_check_filetype( $favicon );

    echo sprintf('<link rel="icon" href="%s" type="%s" />', $favicon, $file_type['type'] );

  }

}
