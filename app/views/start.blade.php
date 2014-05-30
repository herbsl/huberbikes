@extends('layout')

@section('content')
<div id="start-page-1">
	<div class="container hb-container">
		<h1 class="hb-center-inline">Lust auf Biken?</h1>
		<a href="#start-page-2" class="btn btn-primary btn-lg hb-more-btn" role="button">Lesen Sie mehr</a>
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

		$('.hb-more-btn').click(function() {
			$root.animate({
				scrollTop: $($.attr(this, 'href')).offset().top
			}, 750);

			return false;
		});
	});
@stop
