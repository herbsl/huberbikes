@extends('layout')

@section('content')
	<div class="container">
		<div class="page-header">
			<h1>{{ $title }}</h1>
		</div>
		<noscript>
			<p>Dorfen liegt &ouml;stlich von M&uuml;nchen im Landkreis Erding. Sie finden uns direkt an der B15 in der Erdinger Stra&szlig;e 15 (Kreuzung Buchbacher Stra&szlig;e).</p>
		</noscript>
<iframe id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=erdinger+stra%C3%9Fe+15+dorfen&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=49.223579,62.050781&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=Erdinger+Stra%C3%9Fe+15,+84405+Dorfen,+Deutschland&amp;z=14&amp;iwloc=A&amp;ll=48.276103,12.151367&amp;output=embed"></iframe>
	</div>
@stop

@section('style')
	#map {
		width: 100%;
		min-height: 240px;
		padding-bottom: 24px;
	}
@stop

@section('javascript')
	$(document).ready(function() {
		var $win = $(window),
			$map = $('#map');

		$win.on('resize', function() {
			var height = $win.outerHeight(true),
				offset = $map.offset().top;

			$map.css('height', height - offset - 78);
		}).trigger('resize');
	});
@stop
