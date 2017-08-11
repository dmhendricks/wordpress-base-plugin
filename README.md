# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating quick WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

## Features

* Namespaces, PSR-4, dependency autoloading
* PHP and dependency version checking
* Object caching helper class - [Usage Examples](https://github.com/dmhendricks/wordpress-base-plugin/wiki#caching)
* [Many more to come...](#planned-features)

## Requirements

* WordPress 4.0 or higher
* PHP 5.4 or higher

## Installation

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Close the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`

### Composer

1. Modify `composer.json` to suit your needs
1. Run `composer install` to install dependencies and autoload namespace

## TODO / Planned Features

* Fix i18n issues and create means to easily generate `.pot` language file
* Add activation/deactivation/uninstall hooks
* **Add task runner**, related documentation, update .gitignore and rearrange `./assets`
* Add Ajax call example
* Add encrypt/decrypt example. Allow specifying custom salt, else default to WordPress.
* Add `password` field with encrypted `hidden` field
* Add wordpress-settings-api-class example
* Possibly add TGMPA example
* Added GitHub update checker example
* Possibly add Customizer example
* Ability to create dynamic CSS/JS files based on settings
* Allow loading Carbon Fields via [plugin](https://github.com/dmhendricks/carbon-fields-loader) rather than Composer dependency

## Change Log

#### 0.2.0

This is the last version that is compatible with PHP 5.3 (_If_ all of your dependencies are compatible). Future releases will require PHP 5.4 or higher.

* Significantly refactored dependency checking
* Properly hooked admin notices
* Added object cache helper class
* Removed closing ?> tags ([obstschale](https://github.com/dmhendricks/wordpress-base-plugin/issues/1))
* Removed `./vendor` from repo
* Renamed Helpers class to Utils
* Localized many strings
* Fixed various PHP 5.3 issues
* Added minimum PHP version check
* Renamed namespace to `VendorName\MyPlugin`
* Added screenshot

#### 0.1.1

* Moved `/src` to `/app`
* Refactored code
* Added `is_production()` and `is_ajax()` methods

#### 0.1.0

* Initial commit

## Credits

Please support [humans.txt](http://humanstxt.org/). It's an initiative for knowing the people behind a web site. It's an unobtrusive text file that contains information about the different people who have contributed to building the web site.

**Hans-Helge Buerger**

	Contrubutor: https://github.com/obstschale
	URL: https://github.com/obstschale/wordpress-base-plugin
	Twitter: @obstschale
	Author URI: http://hanshelgebuerger.de
	Location: Berlin, Germany

**Carbon Fields**

	URL: http://carbonfields.net/
	Author: htmlBurger.com
	Twitter: @htmlburger
	Author URI: https://htmlburger.com/
	Location: London, England

**PostTypes**

	URL: https://github.com/jjgrainger/PostTypes/
	Author: Joe Grainger
	Twitter: @jjgrainger
	Author URI: https://jjgrainger.co.uk/
	Location: Falmouth, England

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")
