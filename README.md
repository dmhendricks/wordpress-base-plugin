[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc )](https://www.danhendricks.com)
[![Latest Version](https://img.shields.io/github/release/dmhendricks/wordpress-base-plugin.svg)](https://github.com/dmhendricks/wordpress-base-plugin/releases)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/danielhendricks)
[![CloudVerve, LLC](https://img.shields.io/badge/style-CloudVerve-green.svg?style=flat&label=get%20hosted&colorB=AE2A21)](https://2lab.net)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg)](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/LICENSE)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/wordpress-base-plugin.svg?style=social)](https://twitter.com/danielhendricks)

# WordPress Base Plugin

- [Documentation](https://github.com/dmhendricks/wordpress-base-plugin/wiki/)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Future Plans](#future-plans)
- [Change Log](#change-log)
- [Credits](#credits)

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and [Carbon Fields](https://carbonfields.net/) examples. It is intended to be used as a starting point for creating WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme or [extending a child theme](https://www.wp-code.com/wordpress-snippets/wordpress-grandchildren-themes/).

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
* Easy installable ZIP file generation: `npm run zip`
* Automatic translation file (`.pot`) creation. See [Translation](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Translation).
* Shortcodes, widgets (via [Carbon Fields](https://carbonfields.net)) and custom post types (via [PostTypes](https://github.com/jjgrainger/PostTypes/)) examples
* Configuration registry ([docs](https://github.com/dmhendricks/wordpress-toolkit/wiki/ConfigRegistry)) and optional `wp-config.php` [constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants)
* Customizer options
* [More to come...](#future-plans)

**Note:** Gulp and Bower are optional, but handy. If you do not wish to use them, you can delete the references.


## Requirements

* WordPress 4.0 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see the wiki section [Carbon Fields](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) for more info).

## Installation

If you need tips on installing Node.js, Composer, Gulp & Bower, see [Installing Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Installing-Dependencies).

#### The short version:

1. Clone repository to your `plugins` directory
1. Change the four variables in [package.json](https://github.com/dmhendricks/wordpress-base-plugin/wiki#setting-initial-variables)
1. Run `npm install; gulp rename; composer install`

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Clone the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`
1. Renamed the newly created `wordpress-base-plugin` directory to your own plugin slug.

### Next Steps

See the [Getting Started](https://github.com/dmhendricks/wordpress-base-plugin/wiki#getting-started) documentation for further steps.

## Future Plans

* Refactor the Plugin and Loader classes
* Add plugin uninstall hook
* Add [phpdotenv](https://github.com/etelford/phpdotenv) support
* Switch to npm and WebPack for frontend dependency management

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/wordpress-base-plugin/releases) page.

#### Branch: `master`

* Replaced Carbon Fields Loader dependency with [official plugin](https://carbonfields.net/release-archive/)
* Fixed non-static deprecation notice
* Added support for before/after strings to `prefix()`
* Added version check for `wordpress-toolkit`
* Added `get_wpsac_plugin_option()` example to Plugin class
* Updated JS injection to use wordpress-toolkit [ScriptObject](https://github.com/dmhendricks/wordpress-toolkit/wiki/ScriptObject)
* Added Customizer options example (via [inc2734/wp-customizer-framework](https://github.com/inc2734/wp-customizer-framework))
* Added various Carbon Fields custom CSS classes

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")
