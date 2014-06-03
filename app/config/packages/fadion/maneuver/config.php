<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Ignored Files
    |--------------------------------------------------------------------------
    |
    | Maneuver will check .gitignore for ignore files, but you can conveniently
    | add here additional files to be ignored.
    |
    */
    'ignored' => array(
		'assets/**/*',
		'app/database/**/*'
	),

    /*
    |--------------------------------------------------------------------------
    | Default server
    |--------------------------------------------------------------------------
    |
    | Default server to deploy to when running 'deploy' without any arguments.
    | If this options isn't set, deployment will be run to all servers.
    |
    */
    'default' => 'staging',

    /*
    |--------------------------------------------------------------------------
    | Connections List
    |--------------------------------------------------------------------------
    |
    | Servers available for deployment. Specify one or more connections, such
    | as: 'deployment', 'production', 'stating'; each with its own credentials.
    |
    */

    'connections' => array(

        'staging' => array(
            'host'      => $_ENV['ftp.staging.host'],
            'username'  => $_ENV['ftp.staging.username'],
            'password'  => $_ENV['ftp.staging.password'],
            'path'      => $_ENV['ftp.staging.path'],
            'port'      => 21,
            'passive'   => true
        ),

        'production' => array(
            'host'      => $_ENV['ftp.production.host'],
            'username'  => $_ENV['ftp.production.username'],
            'password'  => $_ENV['ftp.production.password'],
            'path'      => $_ENV['ftp.production.path'],
            'port'      => 21,
            'passive'   => true
        ),

    ),

);
