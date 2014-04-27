@extends('layout')

@section('content')
	<div class="container">
		<div class="page-header">
			<h1>{{ $title }}</h1>
		</div>
		<nav>
			<div class="list-group">
				<a class="list-group-item" href="/bikes/mountain">f&uuml;r das Gel&auml;nde</a>
				<a class="list-group-item" href="/bikes/elektro">mit Elektro-Antrieb</a>
				<a class="list-group-item" href="/bikes/active">f&uuml;r Aktive</a>
				<a class="list-group-item" href="/bikes/jugendliche">f&uuml;r Jugendliche</a>
				<a class="list-group-item" href="/bikes/kinder">f&uuml;r Kinder</a>
			</div>
		</nav>
 	</div>
@stop
