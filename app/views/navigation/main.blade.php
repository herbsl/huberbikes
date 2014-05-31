@extends('navigation.base');

@section('navigation-items')
<a href="/navigation/bikes" class="list-group-item">Bikes
	<span class="glyphicon glyphicon-chevron-right pull-right"></span>
</a>
<a href="/navigation/hersteller" class="list-group-item">Hersteller
	<span class="glyphicon glyphicon-chevron-right pull-right"></span>
</a>
@if (Bike::where('price_offer', '>', 0)->count() > 0)
	<a href="{{{ URL::action('bike.index', array('sale' => 'true')) }}}" class="list-group-item">
		<b>
			<span class="text-danger">Sale</span>
		</b>
	</a>
@endif
<span class="list-group-item">
	@include('navigation.search')
</span>
@stop
