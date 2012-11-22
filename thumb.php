<?php


/**
 * Chargement des fonctions du plugin
 */

require_once dirname(__FILE__) . '/functions.inc.php';



/**
 * Chargement de l'API WordPress
 */

if ( ! timthumb_load_wp())
	exit;



/**
 * Chargement des configs TimThumb
 */

foreach(get_timthumb_option('all') as $option_key => $option_value)
{
	if ( ! defined($option_key))
		define($option_key, $option_value);
}

// Cas spéciaux
if (defined('$ALLOWED_SITES'))
{
	$GLOBALS['ALLOWED_SITES'] = explode("\n", constant('$ALLOWED_SITES'));
	$GLOBALS['ALLOWED_SITES'] = array_filter($GLOBALS['ALLOWED_SITES']);
}
if ( ! defined('FILE_CACHE_DIRECTORY'))
{
	define('FILE_CACHE_DIRECTORY', '');
}



/**
 * Chargement du script TimThumb
 */

require_once dirname(__FILE__) . '/vendor/timthumb.php';



?>