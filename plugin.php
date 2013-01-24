<?php
/*
 Plugin Name: TimThumb for WordPress
 Description: 
 Author:      Seebz
 Version:     1.0.beta6
 Author URI:  http://seebz.net/
 */



if ( ! defined('ABSPATH'))
	die('Please do not load this file directly.');



/**
 * Already loaded
 */

if (defined('TIMTHUMB_URL')) return;



/**
 * TimThumb constants
 */

define('TIMTHUMB_VERSION',  '2.8.10');

define('TIMTHUMB_FILENAME', 'thumb.php');
define('TIMTHUMB_BASE_DIR', dirname(__FILE__));
define('TIMTHUMB_BASE_URL', preg_replace('`^'.preg_quote(WP_CONTENT_DIR).'`', WP_CONTENT_URL, TIMTHUMB_BASE_DIR) );
define('TIMTHUMB_URL',      trailingslashit(TIMTHUMB_BASE_URL) . TIMTHUMB_FILENAME);



/**
 * TimThumb settings
 */

require dirname(__FILE__) . '/settings.inc.php';



/**
 * TimThumb functions
 */

require dirname(__FILE__) . '/functions.inc.php';


// Support de timthumb par la fonction wp_get_attachment_image()
add_filter( 'image_downsize', 'timthumb_downsize', 10, 3);



/**
 * Admin options page
 */

if (is_admin())
{
	require dirname(__FILE__) . '/admin/settings-page.php';
}



/**
 * Delete options on plugin deactivation
 */

register_deactivation_hook(__FILE__, 'delete_timthumb_options');



?>