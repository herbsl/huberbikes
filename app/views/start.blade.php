@extends('layout')

@section('content')
<style>

#start-page-1 {
	height: 100%;
}

#start-page-1 {
	background: url(/img/start-bg.jpg) no-repeat center center;
	-moz-background-size: cover;
	-webkit-background-size: cover;
	-o-background-size: cover;
	background-size: cover;

	/* IE8 */
	-ms-behavior: url(/htc/backgroundsize.min.htc);
	z-index: -1;
}

#start-page-2 {
	min-height: 100%;
	overflow: hidden;
}

</style>
<div id="start-page-1">
	<div class="container hb-container">
		<div class="jumbotron hb-jumbotron-transparent">
			<h1>Lust auf Biken?</h1>
			<p><b>Dann sind Sie bei uns richtig.</b></p>
			<a href="#start-page-2" class="btn btn-primary btn-lg hb-margin-top-2x scroll-page-2" role="button">Lesen Sie mehr</a>
		</div>
	</div>
</div>
<div id="start-page-2">
	<div class="container hb-container">
		<div class="page-header">
			<h1>Lust auf Biken?</h1>
		</div>
		<p>Dann sind Sie bei uns richtig, denn Fahrr&auml;der sind unsere Leidenschaft.</p>
		<p>Egal ob Sie ein Mountainbike oder ein bequemes City-Bike suchen, wir haben ...</p>
		<p>Wir freuen uns auf Ihren Besuch.</p>
	</div>
</div>
@stop

@section('javascript')
	$(document).ready(function() {
		var $root = $('html, body');

		$('.navbar-brand').click(function() {
			$root.animate({
				scrollTop: 0
			}, 750);

			return false;
		});

		$('#start-page-1 .scroll-page-2').click(function() {
			$root.animate({
				scrollTop: $($.attr(this, 'href')).offset().top
			}, 750);

			return false;
		});
	});
@stop
