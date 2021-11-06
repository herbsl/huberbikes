<?php return array(

	// Cache checks
	//
	// Various checks that are used to see if Flatten should run
	////////////////////////////////////////////////////////////////////

	// The environments in which Flatten should not run
	'environments' => array(
		'local',
	),

	// The different pages to be ignored when caching
	// They're all regexes so go crazy
	'ignore'       => array(
		'/api/.*',
		'/css/.*',
		'/js/.*',
		'/fonts/.*',
		'/htc/.*',
		'/img/.*',
		'/login',
		'/sitemap.xml'
	),

	// List only specific pages to cache, useful if you have a lot of
	// pages you don't want to see cached
	// The ignored pages will still be substracted from this array
	'only'         => array(),

	// Here you can put variables that will be taken into account when
	// checking if Flatten should run. If the sum of the array is not
	// "true", then Flatten won't start
	'blockers'     => array(
		(class_exists('Auth') && ! Auth::check()) ? true : false,
		(class_exists('Input') && Input::has('nocache') && Input::get('nocache') === 'true') ? false : true,
		(class_exists('Input') && Input::has('option')) ? false : true
	),

	// Cache variables
	////////////////////////////////////////////////////////////////////

	// The default period during which a cached page should be kept (in minutes)
	// 0 means the page never gets refreshed by itself
	'lifetime'     => 36000,

	// An array of string or variables to add to the salt being used
	// to differentiate pages
	'saltshaker'   => array(
		'1636190577'
	),
);
