=== WordPress Base Plugin ===
Contributors: hendridm
Tags: wordpress,base,plugin,boilerplate,composer,carbonfields
Donate link: https://paypal.me/danielhendricks
Requires at least: 4.0
Tested up to: 4.8
License: GPL-2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is intended to be used as a boilerplate for creating quick WordPress plugins.

== Description ==
This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields).

It is intended to be used as a starting point for quickly creating WordPress plugins.

= Requirements =

* WordPress 4.0 or higher
* PHP 5.4 or higher

== Installation ==

= Zip File =

1. Download the ZIP distribution from Github.
2. Extract to your plugin folder.
3. Configure & run Composer.

= Clone Repository =

1. At command prompt, change to your `wp-content/plugins` directory.
2. Close the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`
3. Configure & run Composer.

= Composer =

Once you have the source files:

1. Modify `composer.json` to suit your needs
2. Run `composer install` to install dependencies and autoload namespace

== Frequently Asked Questions ==
= Q. What is Composer? =
A. Composer is an application-level package manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries.

== Screenshots ==
1. Settings Page

== Changelog ==
= 0.2.0 =
* Added Object Cache class
* Added example of loading Font Awesome if enabled in plugin settings
* Removed `./vendor` from repo
* Renamed Helpers Class to Utils
* Tested PHP 5.4 - 7.1 compatibility
* Added minimum PHP version check
* Added screenshot
* Moved `/src` to `/app`

= 0.1.1 =
* Refactored code
* Added `is_production()` and `is_ajax()` methods

= 0.1.0 =
* Initial commit
