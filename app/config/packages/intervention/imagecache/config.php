<?php

function encode_image($image, $width, $height) {
	$quality = '90';
	$format = 'jpg';

	$background = 'rgba(255, 255, 255, 0)';

	if (Input::has('quality')) {
		$quality = Input::get('quality');
	}
	if (Input::has('format')) {
		$format = Input::get('format');
	}

	return $image
		->widen($width)
		->resizeCanvas($width, $height, 'center', false, $background)
		->interlace()
		->encode($format, $quality);
}

return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    | 
    | {route}/{template}/{filename}
    | 
    | Examples: "images", "img/cache"
    |
    */
   
    'route' => 'img/cache',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited 
    | by URI. 
    | 
    | Define as much directories as you like.
    |
    */
    
    'paths' => array(
        public_path('img')
    ),

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation callbacks.
    | The keys of this array will define which templates 
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    */
   
    'templates' => array(
        'x-small' => function($image) {
			return encode_image($image, 320, 240);
        },
        'x-small-2x' => function($image) { 
			return encode_image($image, 640, 480);
        },
        'small' => function($image) { 
			return encode_image($image, 640, 480);
        },
        'small-2x' => function($image) { 
			return encode_image($image, 1280, 960);
        },
        'medium' => function($image) {
			return encode_image($image, 768, 576);
        },
        'medium-2x' => function($image) { 
			return encode_image($image, 1536, 1152);
        },
        'large' => function($image) { 
			return encode_image($image, 1200, 900);
        },
        'large-2x' => function($image) { 
			return encode_image($image, 2400, 1800);
        },
    ),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */
   
    'lifetime' => 259200,

);
