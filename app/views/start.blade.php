@extends('layout')

@section('style')
	html {
		height: 100%;
	}

	body, #singlepage-content, #singlepage-content > .container {
		height: 100%;
	}

	#start-background {
		position: absolute;
		top: 0;

		z-index: -1;

		background: url(/img/start-background.jpg) no-repeat center center; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}

	#start-background, #start-page-1, #start-page-2 {
		height: 100%;
		width: 100%;
		min-height: 480px;
	}

	#start-page-2 {
		padding-top: 70px;
	}


	.jumbotron {
		color: #efefef;
		background-color: transparent;
	}

	@media (max-width: 767px) {
		/* Optimize for small screens: */
		#start-page-1, #start-page-2 {
			padding-top: 50px;
		}
	}

	@media (min-width: 768px and max-width: 1023px) {
		.#start-page-1 jumbotron {
			max-width: 60%;
		}
	}
@stop

@section('content')
	<!-- Background-Image -->
	<div id="start-background"></div>
	<div class="container">
		<!-- Page-1 -->
		<div id="start-page-1">
			<div class="jumbotron">
				<h1>Lust auf Biken?</h1>
				<p><b>Dann sind Sie bei uns richtig.</b></p>
				<a href="#start-page-2" class="btn btn-primary btn-lg btn-margin scroll-page-2" role="button">Lesen Sie mehr <span class="glyphicon glyphicon-arrow-down"></span></a>
			</div>
		</div>
		<!-- Page-2 -->
		<div id="start-page-2">
			<div class="page-header">
				<h1>Lust auf Biken?</h1>
			</div>
			<p>Dann sind Sie bei uns richtig, denn Fahrr&auml;der sind unsere Leidenschaft.</p>
			<p>Egal ob Sie ein Mountainbike oder ein bequemes City-Bike suchen, wir haben ...</p>
			<p>Wir freuen uns auf Ihren Besuch.</p>
			<a href="#" class="scroll-page-1 btn btn-default btn-lg btn-margin" role="button"><span class="glyphicon glyphicon-arrow-up"></span> zur&uuml;ck</a>
		</div>
	</div>
@stop

@section('javascript')
	$(document).ready(function() {
		var $root = $('html, body');

		$('#start-page-2 .scroll-page-1, .navbar-brand').click(function() {
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
