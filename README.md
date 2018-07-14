[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc )](https://www.danhendricks.com/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=wordpress-base-plugin)
[![Latest Version](https://img.shields.io/github/release/dmhendricks/wordpress-base-plugin.svg)](https://github.com/dmhendricks/wordpress-base-plugin/releases)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg)](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/LICENSE)
[![StackShare](https://img.shields.io/badge/tech-stack-0690fa.svg?style=flat)](https://stackshare.io/dmhendricks/wordpress-base-plugin?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin)
[![CloudVerve, LLC](https://img.shields.io/badge/style-CloudVerve-green.svg?style=flat&label=get%20hosted&colorB=AE2A21)](https://2lab.net/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=wordpress-base-plugin)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/danielhendricks)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/wordpress-base-plugin.svg?style=social)](https://twitter.com/danielhendricks)

# WordPress Base Plugin

- [Documentation](https://github.com/dmhendricks/wordpress-base-plugin/wiki/)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Future Goals](#future-goals)
- [Change Log](#change-log)

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and [Carbon Fields](https://carbonfields.net/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin) examples. It is intended to be used as a starting point for creating WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin) from the theme or [extending a child theme](https://www.wp-code.com/wordpress-snippets/wordpress-grandchildren-themes/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin).

### Contributing

Here are some ways that you can contribute:

* Suggest improvements and/or code them.
* Test the translation mechanisms - they have not been extensively tested yet.
* [Report bugs](https://github.com/dmhendricks/wordpress-base-plugin/issues) and/or incompatibilities

## Features

* Namespaces & dependency autoloading
* Version checking (PHP, Carbon Fields)
* Powered by [Composer](https://getcomposer.org/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin), [Gulp](https://gulpjs.com/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin) and [Bower](https://bower.io/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin)
* Object caching (where available; [usage examples](https://github.com/dmhendricks/wordpress-toolkit/wiki/ObjectCache))
* Easy installable ZIP file generation: `npm run zip`
* Automatic translation file (`.pot`) creation. See [Translation](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Translation).
* Network Admin (multisite) options, shortcodes, widgets (via [Carbon Fields](https://carbonfields.net?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin)) and custom post types (via [PostTypes](https://github.com/jjgrainger/PostTypes/)) examples
* Configuration registry ([docs](https://github.com/dmhendricks/wordpress-toolkit/wiki/ConfigRegistry)) and optional `wp-config.php` [constants](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Configuration-&-Constants)
* Customizer examples using [WP Customizer Framework](https://github.com/inc2734/wp-customizer-framework/)
* Define environmental variables via `.env` files ([reference](https://github.com/dmhendricks/wordpress-toolkit/wiki/ToolKit#environment))
* [More to come...](#future-plans)

**Note:** Gulp and Bower are optional, but handy. If you do not wish to use them, you can delete the references.

## Requirements

* WordPress 4.7 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.2 or higher. See the wiki section [Carbon Fields](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) for more info.

## Installation

If you need tips on installing Node.js, Composer, Gulp & Bower, see [Installing Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Installing-Dependencies).

#### The short version:

1. Clone repository to your `plugins` directory
1. Change the four variables in [package.json](https://github.com/dmhendricks/wordpress-base-plugin/wiki#setting-initial-variables). Modify [plugin.json](https://github.com/dmhendricks/wordpress-base-plugin/blob/master/plugin.json) as necessary.
1. Run `npm install; gulp rename; composer install`
1. (optional) For some of the included examples to work, you'll also want to run: `bower install; gulp;`

### Clone Repository

1. At command prompt, change to your `wp-content/plugins` directory.
1. Clone the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`
1. Renamed the newly created `wordpress-base-plugin` directory to your own plugin slug.

### Next Steps

See the [Getting Started](https://github.com/dmhendricks/wordpress-base-plugin/wiki#getting-started) documentation for further steps.

## Future Goals

* Add plugin uninstall support
* Add support for Gulp 4.0
* Switch to npm and WebPack for frontend dependency management
* Remove or replace [tareq1988/wordpress-settings-api-class](https://github.com/tareq1988/wordpress-settings-api-class/) examples with something actively developed
* Clean up Carbon Fields custom CSS classes
* Allow cache flushing by group
* Add Gutenberg examples

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/wordpress-base-plugin/releases) page.

#### Branch: `master`

* None since release

## Screenshot

![Settings Page](https://raw.githubusercontent.com/dmhendricks/wordpress-base-plugin/master/assets/screenshot-1.png "Settings Page")

[![Analytics](https://ga-beacon.appspot.com/UA-67333102-2/dmhendricks/wordpress-base-plugin)](https://github.com/igrigorik/ga-beacon/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fwordpress-base-plugin)
