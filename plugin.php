<?php
/*
 Plugin Name: TimThumb for WordPress
 Description: 
 Author:      Seebz
 Version:     1.0.beta
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

// timthumb_option
function get_timthumb_option($option, $default = false)
{
	$timthumb_options = get_option('timthumb_options', array());
	if ($option == 'all')
	{
		return $timthumb_options;
	}

	return array_key_exists($option, (array) $timthumb_options) ? $timthumb_options[$option] : $default;
}

function delete_timthumb_options()
{
	return delete_option('timthumb_options');
}


// timthumb uri
function get_timthumb_uri( $query_args = array() ) {
	$timthumb_uri = TIMTHUMB_URL;
	if ( $query_args )
	{
		$timthumb_uri .= '?' . http_build_query($query_args, '', '&amp;');
	}

	return apply_filters('get_timthumb_uri', $timthumb_uri, $query_args);
}
	function timthumb_uri( $query_args = array() ) {
		echo get_timthumb_uri( $query_args );
	}


// Support de timthumb par la fonction wp_get_attachment_image()
add_filter( 'image_downsize', 'timthumb_downsize', 10, 3);
function timthumb_downsize($image_downsize, $id, $size) {
	global $_wp_additional_image_sizes;

	if ( $image_downsize )
	{
		return $image_downsize;
	}

	if (is_string($size) && preg_match('`^[0-9]+x[0-9]+$`i', $size) && ! array_key_exists($size, $_wp_additional_image_sizes))
	{
		$size = preg_split('`x`i', $size);
	}

	if ( is_array($size) )
	{
		$img_url = wp_get_attachment_url($id);
		$meta = wp_get_attachment_metadata($id);
		list( $width, $height ) = $size;
		list( $width, $height ) = image_constrain_size_for_editor( $width, $height, $size );

		foreach($meta['sizes'] as $size_name => $meta_size)
		{
			if ($meta_size['width'] == $width && $meta_size['height'] == $height)
			{
				// Size est une taille d'image gérée par WordPress
				return false;
			}
		}

		if ( $width <= $meta['width'] && $height <= $meta['height'] )
		{
			$absolute_img_url = preg_replace(
					'`^https?://' . preg_quote($_SERVER['HTTP_HOST']) . '/`i',
					'/',
					$img_url
				);
			$timthumb_url = get_timthumb_uri(array(
				'src' => $absolute_img_url,
				'w'   => $width,
				'h'   => $height,
			));
			$downsize = array( $timthumb_url, $width, $height, true );

			return apply_filters('timthumb_downsize', $downsize, $image_downsize, $id, $size);
		}
	}

	return false;
}



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