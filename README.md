[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-blue.svg)](https://www.danhendricks.com)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-green.svg)](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/LICENSE)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/wordpress-base-plugin.svg?style=social)](https://twitter.com/danielhendricks)

# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating quick WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

## Features

* Namespaces & dependency autoloading
* Dependency version checking (PHP, Carbon Fields)
* Object caching (when available) - [Usage Examples](https://github.com/dmhendricks/wordpress-base-plugin/wiki#caching)
* Shortcodes, widgets and custom post type (via [PostTypes](https://github.com/jjgrainger/PostTypes/)) examples
* Optional configuration [Constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants) (more are planned)
* [More to come...](#planned-features)

## Requirements

* WordPress 4.0 or higher
* PHP 5.4 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see [Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki#dependencies) for more info)

## Installation

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Close the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`

### Composer

1. Modify `composer.json` to suit your needs
1. Run `composer install` to install dependencies and autoload namespace

**Note:** `hgoebl/mobile-detect` is just loaded as an example. Feel free to remove it.

## Plugin Settings

This plugin loads many of its defaults & settings from `plugin.json`. See [Configuration & Constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants#pluginjson) for more information.

## Planned Features & TODO

* Fix i18n issues, add `gulp-wp-pot` support
* Add task runner, related documentation, update .gitignore and rearrange `./assets`
* Improve configuration management
* Add Ajax call example
* Add encrypt/decrypt example (`password` field with encrypted `hidden` field)
* Add GitHub update class (GitHub Updater 7 is destroying my memory consumption)
* Add Customizer example
* Add dynamically-created CSS/JS files based on settings
* Move Cache class to external dependency

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/wordpress-base-plugin/releases) page.

#### Branch: `master`

* Added `Utils::is_json()` function to test for valid syntax
* Added `register_uninstall_hook` to delete Carbon Fields settings when plugin uninstalled
* Added [wordpress-settings-api-class](https://github.com/tareq1988/wordpress-settings-api-class) settings page example

## Credits

Please support [humans.txt](http://humanstxt.org/). It's an initiative for knowing the people behind a web site. It's an unobtrusive text file that contains information about the different people who have contributed to building the web site.

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

**Carbon Fields**

	URL: https://github.com/tareq1988/wordpress-settings-api-class
	Author: Tareq Hasan
	Twitter: @tareq_cse
	Author URI: https://tareq.co/
	Location: Dhaka, Bangladesh

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")
