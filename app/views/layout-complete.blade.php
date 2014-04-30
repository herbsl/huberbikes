<!doctype html>
@if (isset($cssClass))
<html class="{{{ $cssClass }}}">
@else
<html>
@endif
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		@if (isset($title))
		<title>Bike Service Huber - {{{ $title }}}</title>
		@else
		<title>Bike Service Huber</title>
		@endif
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="description" content="TODO">
		<link href="{{{ App::make('asset')->rev('/css/main.min.css') }}}" rel="stylesheet" type="text/css">
		<script>@include('assets')</script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
        @include('navigation')
		<div id="singlepage-content">@yield('content')</div>
		@include('kontakt-modal')
        @include('oeffnungszeiten-modal')
		@if (App::environment('local'))
		<script src="http://{{{ gethostname() }}}:35729/livereload.js?snipver=1"></script>
		@endif
		<script src="{{{ App::make('asset')->rev('/js/main.min.js') }}}"></script>
		<script id="singlepage-javascript">@yield('javascript')</script>
	</body>
</html>
