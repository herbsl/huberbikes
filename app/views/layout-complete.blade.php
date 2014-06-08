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
		<script>@include('assets')</script>
		<link href="{{{ App::make('asset')->rev('/css/main.min.css') }}}" rel="stylesheet" type="text/css">
		<!--[if lt IE 9]>
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
		@if (App::environment('local'))
		<script src="http://{{{ gethostname() }}}:35729/livereload.js?snipver=1"></script>
		@endif
		<script src="{{{ App::make('asset')->rev('/js/main.min.js') }}}"></script>
		<script id="singlepage-javascript">@yield('javascript')</script>
		<script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-51739955-1');ga('send','pageview');
        </script>
	</body>
</html>
