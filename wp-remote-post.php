<?php
/**
 * WP Remote Post Example
 *
 * An example plugin demonstrating how to use `wp_remote_post`.
 *
 * @package   WP_Remote_Post
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com
 * @copyright 2013 Tom McFarlin
 *
 * @wordpress-plugin
 * Plugin Name: WP Remote Post Example
 * Plugin URI:  http://tommcfarlin.com/wp-remote-post/
 * Description: An example plugin demonstrating how to use `wp_remote_post`.
 * Version:     1.0.0
 * Author:      Tom McFarlin
 * Author URI:  http://tommcfarlin.com
 * Text Domain: wprp-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

require_once( plugin_dir_path( __FILE__ ) . 'class-wp-remote-post.php' );
WP_Remote_Post_Example::get_instance();