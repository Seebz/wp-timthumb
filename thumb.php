<?php


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

// Cas spécial : $ALLOWED_SITES
if (defined('$ALLOWED_SITES'))
{
	$GLOBALS['ALLOWED_SITES'] = explode("\n", constant('$ALLOWED_SITES'));
	$GLOBALS['ALLOWED_SITES'] = array_filter($GLOBALS['ALLOWED_SITES']);
}



/**
 * Chargement du script TimThumb
 */

include 'vendor/timthumb.php';



/**
 * Fonction de chargement de l'API WordPress
 */

function timthumb_load_wp()
{
	// wp-load.php génère parfois une erreur
	ob_start();

	// On recherche le fichier 'wp-load.php'
	$dir = dirname(__FILE__);
	while( ! file_exists($dir . '/wp-load.php'))
	{
		$dir = dirname($dir);
		if (strlen($dir) < 4)
		{
			ob_end_clean();
			return false;
		}
	}

	// Inclusion
	if (file_exists($dir . '/wp-load.php'))
	{
		define('WP_USE_THEMES', false);
		//require $dir . '/wp-blog-header.php';
		require $dir . '/wp-load.php';

		ob_end_clean();
		return true;
	}

	ob_end_clean();
}



?>