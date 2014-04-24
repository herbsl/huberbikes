<!doctype html>
<html class="no-js">
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
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="description" content="TODO">
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<style>
		@include('main-style')
		</style>
		<style id="singlepage-style">
		@yield('style')
		</style>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
        @include('navigation')
		<div id="singlepage-content">
        @yield('content')
		</div>
		@include('kontakt-modal')
        @include('oeffnungszeiten-modal')
		<script src="/js/vendor/modernizr-2.7.1.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="/js/main.min.js"></script>
		<script id="singlepage-javascript">
		@yield('javascript')
		</script>
	</body>
</html>
