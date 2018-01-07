<?php
namespace VendorName\PluginName;

class TGMPA extends Plugin {

  function __construct() {

    // Check for required/recommended plugins
    add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );

  }

  /**
    * Uses the TGMPA library to check for required/recommended plugins.
    * @since 0.2.1
    * @link http://tgmpluginactivation.com/configuration/ Configuring TGMPA
    */
  public function register_required_plugins() {

    /*
  	 * Array of plugin arrays. Required keys are name and slug.
  	 * If the source is NOT from the .org repo, then source is also required.
  	 */
  	$plugins = array(

  		// This is an example of how to include a plugin bundled with a theme.
  		array(
  			'name'               => 'Carbon Fields', // The plugin name.
  			'slug'               => 'carbon-fields', // The plugin slug (typically the folder name).
  			'source'             => 'https://carbonfields.net/zip/latest/', // The plugin source.
  			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
  			'version'            => '2.1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
  			'force_activation'   => true // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
  		)

  	);

    /*
  	 * Array of configuration settings. Amend each line as needed.
  	 *
  	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
  	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
  	 * sending in a pull-request with .po file(s) with the translations.
  	 *
  	 * Only uncomment the strings in the config array if you want to customize the strings.
  	 */
  	$config = array(
  		'id'           => $this->prefix( 'tgmpa' ), // Unique ID for hashing notices for multiple instances of TGMPA.
  		'menu'         => 'tgmpa-install-plugins',  // Menu slug.
  		'parent_slug'  => 'themes.php',             // Parent menu slug.
  		'capability'   => 'edit_theme_options',     // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
  		'has_notices'  => true,                     // Show admin notices or not.
  		'dismissable'  => true,                     // If false, a user cannot dismiss the nag message.
  		'is_automatic' => true,                     // Automatically activate plugins after installation or not.
      'strings'      => array(
  			'notice_can_install_required' => _n_noop(
					'This plugin has the following dependency: %1$s.',
					'This plugin has the following dependencies: %1$s.',
					self::$textdomain
				),
  		)
  	);

  	tgmpa( $plugins, $config );

  }

}
