=== WordPress Base Plugin ===
Contributors: hendridm
Tags: wordpress,base,plugin,boilerplate,composer,carbonfields
Donate link: https://paypal.me/danielhendricks
Requires at least: 4.0
Tested up to: 4.8.1
License: GPL-2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is intended to be used as a boilerplate for creating quick WordPress plugins.

== Description ==
This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields).

It is intended to be used as a starting point for quickly creating WordPress plugins.

= Requirements =

* WordPress 4.0 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see [Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki#dependencies) for more info)

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
= Q. Why do I get the error "Warning: require( ... /autoload.php): failed to open stream: No such file or directory" when I try to activate it?
A. You need to use the command prompt and [run Composer](https://github.com/dmhendricks/wordpress-base-plugin#composer) before this plugin will work.

= Q. What is Composer? =
A. Composer is an application-level package manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries.

== Screenshots ==
1. Settings Page
