<?php return array(

    // Turn on/off minification
    'enabled' => isset($_ENV['htmlmin.enabled']) ? $_ENV['htmlmin.enabled'] : false,

    // If you are using a javascript framework that conflicts
    // with Blade's tags, you can change them here
    'blade' => array(
        'contentTags' => array('{{', '}}'),
        'escapedContentTags' => array('{{{', '}}}')
    )

);
