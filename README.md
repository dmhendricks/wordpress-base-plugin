[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-blue.svg)](https://www.danhendricks.com)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/danielhendricks)
[![WP Engine](https://f001.backblazeb2.com/file/hendricks/images/badge/wpengine.svg)](http://bit.ly/WPEnginePlans)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg)](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/LICENSE)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/wordpress-base-plugin.svg?style=social)](https://twitter.com/danielhendricks)

# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

### Contributing

Here are some ways that you can contribute:

* Suggest improvements and/or code them.
* Test the translation mechanisms - they have not been extensively tested yet.
* [Report bugs](https://github.com/dmhendricks/wordpress-base-plugin/issues) and/or incompatibilities

## Features

* Namespaces & dependency autoloading
* Version checking (PHP, Carbon Fields)
* Powered by [Composer](https://getcomposer.org/), [Gulp](https://gulpjs.com/) and [Bower](https://bower.io/)
* Object caching (where available; [usage examples](https://github.com/dmhendricks/wordpress-toolkit/wiki/ObjectCache))
* Automatic translation file (`.pot`) creation. See [Translation](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Translation).
* Shortcodes, widgets and custom post type (via [PostTypes](https://github.com/jjgrainger/PostTypes/)) examples
* Configuration registry ([docs](https://github.com/dmhendricks/wordpress-toolkit/wiki/ConfigRegistry)) and optional `wp-config.php` [Constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants)
* [More to come...](#planned-features)

**Note:** Gulp and Bower are optional, but handy. If you do not wish to use them, you can delete the references.


## Requirements

* WordPress 4.0 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see the wiki section [Carbon Fields](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) for more info)

## Installation

If you need tips on installing Node.js, Composer, Gulp & Bower, see [Installing Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Installing-Dependencies).

#### The short version:

1. Clone repository to `plugins`
1. Change the four variables in [package.json](https://github.com/dmhendricks/wordpress-base-plugin/wiki#setting-initial-variables)
1. Run `npm install; gulp rename; composer install`

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Clone the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`
1. Renamed the newly created `wordpress-base-plugin` directory to your own plugin slug.

### Next Steps

See the [Getting Started](https://github.com/dmhendricks/wordpress-base-plugin/wiki#getting-started) documentation for further steps.

## Planned Features & TODO

* Add Customizer example
* Add dynamically-created CSS/JS files based on settings
* Add encrypted text field example
* Add [phpdotenv](https://github.com/vlucas/phpdotenv) support
* Move `get_script_version()`, `get_script_path()` and `get_script_url()` to Helpers

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/wordpress-base-plugin/releases) page.

#### Branch: `master`

* Added quick start documentation

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

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")
