[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-blue.svg)](https://www.danhendricks.com)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-green.svg)](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/LICENSE)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/wordpress-base-plugin.svg?style=social)](https://twitter.com/danielhendricks)

# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating quick WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

## Features

* Namespaces & dependency autoloading
* Version checking (PHP, Carbon Fields)
* Powered by [Composer](https://getcomposer.org/), [Gulp](https://gulpjs.com/) and [Bower](https://bower.io/)
* Object caching (where available; [usage examples](https://github.com/dmhendricks/wordpress-toolkit/wiki/ObjectCache))
* Automatic translation file (`.pot`) creation. See [Translation](https://github.com/dmhendricks/wordpress-base-plugin/wiki#translation).
* Shortcodes, widgets and custom post type (via [PostTypes](https://github.com/jjgrainger/PostTypes/)) examples
* Configuration registry ([docs](https://github.com/dmhendricks/wordpress-toolkit/wiki/ConfigRegistry)) and optional `wp-config.php` [Constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants)
* [More to come...](#planned-features)

## Requirements

* WordPress 4.0 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see [here](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) for more info)

## Installation

If you need tips on installing Node.js, Composer, Gulp & Bower, see [Installing Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki#installing-dependencies).

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Close the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`

### Composer

1. Modify `composer.json` to suit your needs.
1. Run `composer install` to install dependencies and autoload namespace.

If you want to install Carbon Fields as a [dependency](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) rather than via a [loader plugin](https://github.com/dmhendricks/carbon-fields-loader):

```
$ composer require htmlburger/carbon-fields
```

### NPM

1. Modify `package.json` to suit your needs. Specifically, change the `config` section.
1. Run `npm install` to install dependencies.

### Bower

This step is only necessary for the "Clear Cache" Ajax example. Whether or not you choose to use Bower is up to you. Alternatively, you may put JavaScript dependencies in `src/vendor` and enqueue `assets/js/wordpress-base-plugin-vendor.js` as needed.

```
$ bower install
```

### Gulp

Using Gulp is also optional (but recommended). If you wish to try the base plugin with all of its examples, you will need to run Gulp to process the JavaScripts:

```
$ gulp
```

### Next Steps

See the [Getting Started](https://github.com/dmhendricks/wordpress-base-plugin/wiki#getting-started) documentation for further steps.

## Plugin Settings

This plugin loads many of its defaults & settings from `plugin.json`. See [Configuration & Constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants#pluginjson) for more information.

## Planned Features & TODO

#### Before 0.3.0 Pre-Release

* Update documentation to reflect recent changes
* Add gulp task to package plugin as ZIP file; move NPM scripts to gulp tasks
* Use [TGMPA](http://tgmpluginactivation.com/) for Carbon Fields dependency checking
* Simplify/clean-up version checking in general

#### Future Releases

* Add Customizer example
* Add dynamically-created CSS/JS files based on settings

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/wordpress-base-plugin/releases) page.

#### Branch: `master`

* Bumped minimum PHP version check to 5.6
* Added [Gulp](https://gulpjs.com/) for task automation (SASS, JS processing)
* Added [Bower](https://bower.io/) to (optionally) load third-party scripts
* Drastically refactored configuration management
* Split out settings pages, shortcodes, CPT & widgets into separate files/classes (thanks [obstschale](https://github.com/obstschale/wordpress-base-plugin))
* Added `wp-pot-cli` to `package.json` to create `.pot` translation file
* Added `register_uninstall_hook` to delete Carbon Fields settings when plugin uninstalled
* Added [wordpress-settings-api-class](https://github.com/tareq1988/wordpress-settings-api-class) settings page example
* Added `WPTK_DISABLE_CACHE` constant
* Added `VERSION` constant ([info](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants#defined-by-plugin))
* Added [wordpress-toolkit](https://github.com/dmhendricks/wordpress-toolkit) as dependency
* Renamed `Utils` class to `Helpers`
* Added Ajax example "Clear Cache" link to admin bar dropdown

## Credits

Please support [humans.txt](http://humanstxt.org/). It's an initiative for knowing the people behind a web site. It's an unobtrusive text file that contains information about the different people who have contributed to building the web site.

**Carbon Fields**

	URL: http://carbonfields.net/
	Author: htmlBurger.com
	Twitter: @htmlburger
	Author URI: https://htmlburger.com/
	Location: London, England

**WPGulp**

	URL: https://labs.ahmadawais.com/WPGulp/
	Author: Ahmad Awais
	Twitter: @mrahmadawais
	Author URI: https://ahmadawais.com/
	Location: Asal, Pakistan

**PostTypes**

	URL: https://github.com/jjgrainger/PostTypes/
	Author: Joe Grainger
	Twitter: @jjgrainger
	Author URI: https://jjgrainger.co.uk/
	Location: Falmouth, England

**WordPress Settings API Class**

	URL: https://github.com/tareq1988/wordpress-settings-api-class
	Author: Tareq Hasan
	Twitter: @tareq_cse
	Author URI: https://tareq.co/
	Location: Dhaka, Bangladesh

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")
