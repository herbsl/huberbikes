@extends('navigation.base')

@section('navigation-items')
@foreach (Manufacturer::all() as $manufacturer)
	<a class="list-group-item" href="{{{ URL::action('bike.index', array( 'hersteller' => $manufacturer->name)) }}}">{{{ $manufacturer->name }}}</a>
@endforeach
@stop
