<?php



/**
 * Settings sections
 */

$GLOBALS['TimThumb_Settings_Sections'] = array(
	'main' => array(
		'title' => __('Main Settings', 'wp-timthumb'),
	),
	'image_fetching' => array(
		'title' => __('Image fetching and caching', 'wp-timthumb'),
	),
	'browser_caching' => array(
		'title' => __('Browser caching', 'wp-timthumb'),
	),
	'image_size' => array(
		'title' => __('Image size and defaults', 'wp-timthumb'),
	),
);



/**
 * Settings fields
 */

$GLOBALS['TimThumb_Settings_Fields'] = array(
	// Section 'main'
	'DEBUG_ON' => array(
		'section' => 'main',
		'title'   => __('Debug on', 'wp-timthumb'),
		'desc'    => __('Enable debug logging to web server error log (STDERR)', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => false,
	),
	'DEBUG_LEVEL' => array(
		'section' => 'main',
		'title'   => __('Debug level', 'wp-timthumb'),
		'desc'    => __('Debug level 1 is less noisy and 3 is the most noisy'),
		'type'    => 'numeric',
		'default' => 1,
	),
	'MEMORY_LIMIT' => array(
		'section' => 'main',
		'title'   => __('Memory limit', 'wp-timthumb'),
		'desc'    => __('Set PHP memory limit'),
		'type'    => 'text',
		'default' => '30M',
	),
	'BLOCK_EXTERNAL_LEECHERS' => array(
		'section' => 'main',
		'title'   => __('Block external leechers', 'wp-timthumb'),
		'desc'    => __('If the image or webshot is being loaded on an external site, display a red "No Hotlinking" gif', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => false,
	),

	// Section 'image_fetching'
	'ALLOW_EXTERNAL' => array(
		'section' => 'image_fetching',
		'title'   => __('Allow external', 'wp-timthumb'),
		'desc'    => __('Allow image fetching from external websites. Will check against ALLOWED_SITES if ALLOW_ALL_EXTERNAL_SITES is false', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => true,
	),
	'ALLOW_ALL_EXTERNAL_SITES' => array(
		'section' => 'image_fetching',
		'title'   => __('Allow all external sites', 'wp-timthumb'),
		'desc'    => __('Less secure', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => false,
	),
	'$ALLOWED_SITES' => array(
		'section' => 'image_fetching',
		'title'   => __('Allowed sites', 'wp-timthumb'),
		'desc'    => __('If ALLOW_EXTERNAL is true and ALLOW_ALL_EXTERNAL_SITES is false, then external images will only be fetched from these domains and their subdomains', 'wp-timthumb'),
		'type'    => 'textarea',
		'default' => implode("\n", array(
				'flickr.com',
				'staticflickr.com',
				'picasa.com',
				'img.youtube.com',
				'upload.wikimedia.org',
				'photobucket.com',
				'imgur.com',
				'imageshack.us',
				'tinypic.com',
			)),
	),
	'FILE_CACHE_ENABLED' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache enabled', 'wp-timthumb'),
		'desc'    => __('Should we store resized/modified images on disk to speed things up?', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => true,
	),
	'FILE_CACHE_TIME_BETWEEN_CLEANS' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache time between cleans', 'wp-timthumb'),
		'desc'    => __('How often the cache is cleaned', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 86400,
	),
	'FILE_CACHE_MAX_FILE_AGE' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache max file age', 'wp-timthumb'),
		'desc'    => __('How old does a file have to be to be deleted from the cache', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 86400,
	),
	'FILE_CACHE_SUFFIX' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache suffix', 'wp-timthumb'),
		'desc'    => __('What to put at the end of all files in the cache directory so we can identify them', 'wp-timthumb'),
		'type'    => 'text',
		'default' => '.timthumb.txt',
	),
	'FILE_CACHE_PREFIX' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache prefix', 'wp-timthumb'),
		'desc'    => __('What to put at the beg of all files in the cache directory so we can identify them', 'wp-timthumb'),
		'type'    => 'text',
		'default' => 'timthumb',
	),
	'FILE_CACHE_DIRECTORY' => array(
		'section' => 'image_fetching',
		'title'   => __('File cache directory', 'wp-timthumb'),
		'desc'    => __('Directory where images are cached. Left blank it will use the system temporary directory (which is better for security)', 'wp-timthumb'),
		'type'    => 'text',
		'default' => '',
	),
	'MAX_FILE_SIZE' => array(
		'section' => 'image_fetching',
		'title'   => __('Maxfile size', 'wp-timthumb'),
		'desc'    => __("10 Megs is 10485760. This is the max internal or external file size that we'll process", 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 10485760,
	),
	'CURL_TIMEOUT' => array(
		'section' => 'image_fetching',
		'title'   => __('Curl timeout', 'wp-timthumb'),
		'desc'    => __("Timeout duration for Curl. This only applies if you have Curl installed and aren't using PHP's default URL fetching mechanism", 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 20,
	),
	'WAIT_BETWEEN_FETCH_ERRORS' => array(
		'section' => 'image_fetching',
		'title'   => __('Wait between fetch errors', 'wp-timthumb'),
		'desc'    => __('Time to wait between errors fetching remote file', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 3600,
	),

	// section 'browser_caching'
	'BROWSER_CACHE_MAX_AGE' => array(
		'section' => 'browser_caching',
		'title'   => __('Browser cache max age', 'wp-timthumb'),
		'desc'    => __('Time to cache in the browser', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 864000,
	),
	'BROWSER_CACHE_DISABLE' => array(
		'section' => 'browser_caching',
		'title'   => __('Browser cache disable', 'wp-timthumb'),
		'desc'    => __('Use for testing if you want to disable all browser caching', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => false,
	),

	// section 'image_size'
	'MAX_WIDTH' => array(
		'section' => 'image_size',
		'title'   => __('Max width', 'wp-timthumb'),
		'desc'    => __('Maximum image width', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 1500,
	),
	'MAX_HEIGHT' => array(
		'section' => 'image_size',
		'title'   => __('Max height', 'wp-timthumb'),
		'desc'    => __('Maximum image height', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 1500,
	),
	'NOT_FOUND_IMAGE' => array(
		'section' => 'image_size',
		'title'   => __('Not found image', 'wp-timthumb'),
		'desc'    => __('Image to serve if any 404 occurs', 'wp-timthumb'),
		'type'    => 'text',
		'default' => '',
	),
	'ERROR_IMAGE' => array(
		'section' => 'image_size',
		'title'   => __('Error image', 'wp-timthumb'),
		'desc'    => __('Image to serve if an error occurs instead of showing error message', 'wp-timthumb'),
		'type'    => 'text',
		'default' => '',
	),
	'PNG_IS_TRANSPARENT' => array(
		'section' => 'image_size',
		'title'   => __('PNG is transparent', 'wp-timthumb'),
		'desc'    => __('Define if a png image should have a transparent background color. Use False value if you want to display a custom coloured canvas_colour', 'wp-timthumb'),
		'type'    => 'boolean',
		'default' => false,
	),
	'DEFAULT_Q' => array(
		'section' => 'image_size',
		'title'   => __('Default Q', 'wp-timthumb'),
		'desc'    => __('Default image quality', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 90,
	),
	'DEFAULT_ZC' => array(
		'section' => 'image_size',
		'title'   => __('Default ZC', 'wp-timthumb'),
		'desc'    => __('Default zoom/crop setting', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 1,
	),
	'DEFAULT_F' => array(
		'section' => 'image_size',
		'title'   => __('Default F', 'wp-timthumb'),
		'desc'    => __('Default image filters', 'wp-timthumb'),
		'type'    => 'text',
		'default' => '',
	),
	'DEFAULT_S' => array(
		'section' => 'image_size',
		'title'   => __('Default S', 'wp-timthumb'),
		'desc'    => __('Default sharpen value', 'wp-timthumb'),
		'type'    => 'numeric',
		'default' => 0,
	),
	'DEFAULT_CC' => array(
		'section' => 'image_size',
		'title'   => __('Default CC', 'wp-timthumb'),
		'desc'    => __('Default canvas colour', 'wp-timthumb'),
		'type'    => 'text',
		'default' => 'ffffff',
	),
);


?>