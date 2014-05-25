<?php

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

        'small' => function($image) { 
			return $image->widen(320)->resizeCanvas(320, 240, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'medium' => function($image) { 
			return $image->widen(640)->resizeCanvas(640, 480, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'large' => function($image) { 
			return $image->widen(1280)->resizeCanvas(1280, 960, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'x-large' => function($image) { 
			return $image->widen(1920)->resizeCanvas(1920, 1440, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
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
