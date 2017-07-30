# WordPress Base Plugin

## Description

This is a boilerplate WordPress plugin featuring namespace autoloading and integration with [Carbon Fields](https://github.com/htmlburger/carbon-fields). It is intended to be used as a starting point for creating quick WordPress plugins. It contains several examples and dependencies to get you started.

It may also be used as the means of [separating custom code](http://www.billerickson.net/core-functionality-plugin/) from the theme.

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
* Update to comply with new Carbon Fields standards
* Add task runner, related documentation and update .gitignore and rearrange `./assets`
* Fix i18n issues and create `.pot` language file
* Add Ajax call example
* Add encrypt/decrypt example
* Add hidden `password` field with encrypted `hidden` field
* Possibly add hooks
* Possibly add TGMPA example
* Test compatibility with WordPress 4.0 and higher

## Change Log

#### 0.2.0

* Added experimental Cache class
* Added example of loading Font Awesome if enabled in plugin settings
* Removed `./vendor` from repo
* Renamed Helpers Class to Utils
* Tested PHP 5.3 - 7.1 compatibility
* Added minimum PHP version check

#### 0.1.2

* Moved `/src` to `/app`

#### 0.1.1

* Refactored code
* Added `is_production()` and `is_ajax()` methods

#### 0.1.0

* Initial commit

## Credits

Please support [humans.txt](http://humanstxt.org/). It's an initiative for knowing the people behind a web site. It's an unobtrusive text file that contains information about the different people who have contributed to building the web site.

**Carbon Fields:**

	URL: http://carbonfields.net/
	Author: htmlBurger.com
	Twitter: @htmlburger
	Author URI: https://htmlburger.com/
	Location: London, England

**PostTypes:**

	URL: https://github.com/jjgrainger/PostTypes/
	Author: Joe Grainger
	Twitter: @jjgrainger
	Author URI: https://jjgrainger.co.uk/
	Location: Falmouth, England
