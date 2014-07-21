<!doctype html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		@include('title')
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes,minimal-ui">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-title" content="Huber Bikes">
		@if (isset($description))
		<meta name="description" content="{{{ $description }}}">
		@endif
		<style>@include('style-main')</style>
		<!--[if lt IE 9]>
			<link href="{{{ Asset::rev('/css/main.min.css') }}}" rel="stylesheet" type="text/css">
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
        @include('navigation-main')
		<div id="singlepage-content">
			@yield('content')
        	@include('navigation-secondary')
		</div>
		@include('spinner')
		@include('scroll-top')
		@include('kontakt-modal')
        @include('oeffnungszeiten-modal')
		<script>@include('assets')</script>
		<script>@include('js-main')</script>
		<script id="singlepage-javascript"></script>
		@if (App::environment('local'))
		<script src="http://{{{ gethostname() }}}:35729/livereload.js?snipver=1"></script>
		@endif
	</body>
</html>
