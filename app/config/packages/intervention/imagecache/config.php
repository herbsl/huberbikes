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
        'x-small' => function($image) { 
			return $image->widen(320)->resizeCanvas(320, 240, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'x-small-2x' => function($image) { 
			return $image->widen(640)->resizeCanvas(640, 480, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'small' => function($image) { 
			return $image->widen(640)->resizeCanvas(640, 480, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'small-2x' => function($image) { 
			return $image->widen()->resizeCanvas(1280, 960, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'medium' => function($image) { 
			return $image->widen(768)->resizeCanvas(768, 576, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'medium-2x' => function($image) { 
			return $image->widen(1536)->resizeCanvas(1536, 1152, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'large' => function($image) { 
			return $image->widen(1200)->resizeCanvas(1200, 900, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
        },
        'large-2x' => function($image) { 
			return $image->widen(2400)->resizeCanvas(2400, 1800, 'center', false, 'rgba(255, 255, 255, 0)')->interlace();
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
