@extends('navigation.base');

@section('navigation-items')
<a href="/navigation/bikes" class="list-group-item">Bikes
	<span class="glyphicon glyphicon-chevron-right pull-right"></span>
</a>
<a href="/navigation/hersteller" class="list-group-item">Hersteller
	<span class="glyphicon glyphicon-chevron-right pull-right"></span>
</a>
<a href="/bikes/sale" class="list-group-item">
	<b>
		<span class="text-danger">Sale</span>
	</b>
</a>
<span class="list-group-item">
	@include('search-form')
</span>
@stop
