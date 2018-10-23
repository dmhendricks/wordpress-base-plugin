=== WordPress Base Plugin ===
Contributors: hendridm
Tags: wordpress,base,plugin,boilerplate,composer,carbonfields
Donate link: https://paypal.me/danielhendricks
Requires at least: 4.6
Requires PHP: 5.6
Tested up to: 5.0
Stable tag: 0.4.0
License: GPL-2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is intended to be used as a boilerplate for creating WordPress plugins.

== Description ==
This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields).

It is intended to be used as a starting point for creating WordPress plugins.

= Requirements =

* WordPress 4.6 or higher
* PHP 5.6 or higher
* [Carbon Fields](https://github.com/htmlburger/carbon-fields) 2.0 or higher (see the wiki section on [Carbon Fields](https://github.com/dmhendricks/wordpress-base-plugin/wiki#carbon-fields) for more info)

== Installation ==
If you need tips on installing Node.js, Composer, Gulp & Bower, see [Installing Dependencies](https://github.com/dmhendricks/wordpress-base-plugin/wiki/Installing-Dependencies).

= Clone Repository =

1. At command prompt, change to your `wp-content/plugins` directory.
2. Clone the repository: `git clone https://github.com/dmhendricks/wordpress-base-plugin.git`
3. Renamed the newly created `wordpress-base-plugin` directory to your own plugin slug.

= Next Steps =

See the [Getting Started](https://github.com/dmhendricks/wordpress-base-plugin/wiki#getting-started) documentation for further steps.

== Frequently Asked Questions ==
= Q. Why do I get the error "Warning: require( ... /autoload.php): failed to open stream: No such file or directory" when I try to activate it?
A. You need to use the command prompt and [run Composer](https://github.com/dmhendricks/wordpress-base-plugin#composer) before this plugin will work.

= Q. What is Composer? =
A. Composer is an application-level package manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries.

== Screenshots ==
1. Settings Page
