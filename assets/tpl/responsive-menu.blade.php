@extends('layout')

@section('content')
	<div class="container">
		<div class="page-header">
			<h1>{{ $title }}</h1>
		</div>
		<nav>
			<div class="list-group">
				<a href="/" class="list-group-item">Start</a>
				<a class="list-group-item" href="/bikes">Bikes<span class="glyphicon glyphicon-chevron-right pull-right text-primary"></span></a>
				<a class="list-group-item" href="/kontakt">Kontakt</a>
				<a class="list-group-item" href="/oeffnungszeiten">&Ouml;ffnungszeiten</a>
				<a class="list-group-item" href="/so-finden-sie-uns">So finden Sie uns</a>
			</div>
		</nav>
 	</div>
@stop
