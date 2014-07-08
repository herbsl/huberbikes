@extends('navigation.base')

@section('navigation-items')
@foreach (Manufacturer::where('disabled', '=', '0')->get() as $manufacturer)
	<a class="list-group-item" href="{{{ URL::action('bike.index', array( 'hersteller' => $manufacturer->name)) }}}">{{{ $manufacturer->name }}}
		<span class="glyphicon glyphicon-chevron-right pull-right"></span>
	</a>
@endforeach
@stop
