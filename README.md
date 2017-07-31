# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating quick WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

## Features

* Namespaces, PSR-4, dependency autoloading
* Object caching helper
* [Many more to come...](#planned-features)

## Requirements

* WordPress 4.0 or higher
* PHP 5.4 or higher*

*PHP 5.3 will work if all of your dependencies are compatible.*

## Installation

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Close the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`

### Composer

1. Modify `composer.json` to suit your needs
1. Run `composer install` to install dependencies and autoload namespace

## Planned Features

* Refactor code
* Add/test/document object caching class
* Add activation/deactivation/uninstall hooks
* Update to comply with new Carbon Fields standards
* Add task runner, related documentation and update .gitignore and rearrange `./assets`
* Fix i18n issues and create `.pot` language file
* Create means to autogenerate language file
* Add Ajax call example
* Add encrypt/decrypt example
* Add hidden `password` field with encrypted `hidden` field
* Possibly add hooks (maybe to assist in consolidation of multiple settings pages?)
* Possibly add TGMPA example
* Possible add Customizer example
* Add wordpress-settings-api-class example(s)
* Allow loading Carbon Fields via [plugin](https://github.com/dmhendricks/carbon-fields-loader) rather than Composer dependency
* Test compatibility with WordPress 4.0 and higher
* Add uninstall.php

## Change Log

#### 0.2.0

* Added Object Cache class
* Added example of loading Font Awesome if enabled in plugin settings
* Removed closing ?> tags ([obstschale](https://github.com/dmhendricks/wordpress-base-plugin/issues/1))
* Removed `./vendor` from repo
* Renamed Helpers class to Utils
* Tested PHP 5.4 - 7.1 compatibility
* Fixed various PHP 5.3 issues; bumped minimum suggested version to 5.4.0
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
