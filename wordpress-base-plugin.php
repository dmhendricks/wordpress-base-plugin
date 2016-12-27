<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WordPress Base Plugin
 * Plugin URI:        http://plugin-name.com/
 * Description:       A starter template for WordPress plugins
 * Version:           0.1.0
 * Author:            Daniel M. Hendricks
 * Author URI:        https://danhendricks.com/
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 */

/*	Copyright 2017	  Daniel M. Hendricks (https://www.danhendricks.com/)

	This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define("_PLUGIN_NAMESPACE", 'Nimbium\MyPlugin');

require( __DIR__ . '/vendor/autoload.php' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Initialize plugin
new \Nimbium\MyPlugin\Plugin(array(
	'data' => get_plugin_data(__FILE__),
	'path' => realpath(plugin_dir_path(__FILE__)).DIRECTORY_SEPARATOR,
	'url' => plugin_dir_url(__FILE__)
));
?>