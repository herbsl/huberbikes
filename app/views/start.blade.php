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
		<p>Egal ob Sie ein sportliches Mountainbike oder ein ausdauerndes E-Bike suchen, auf unserer Seite finden Sie ein ausgew&auml;hltes Sortiment.</p><p>Sie haben noch Fragen, W&uuml;nsche oder wurde nicht f&uuml;ndig? Sprechen Sie uns direkt an, wir nehmen uns Zeit und finden die perfekte L&ouml;sung f&uuml;r Sie, denn individuelle und kompetente Beratung ist unser Anspruch.</p>
		<p class="hb-margin-top-2x">Viel Spa&szlig; auf www.huberbikes.de</p>
		<p><strong>Peter Huber</strong></p>
	</div>
</div>
@stop

@section('javascript')
(function($) {
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
})(jQuery);
@stop
