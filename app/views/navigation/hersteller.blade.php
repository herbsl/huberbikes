@extends('navigation.base')

@section('navigation-items')
@foreach (Manufacturer::all() as $manufacturer)
	<a class="list-group-item" href="/bikes/hersteller/{{{ $manufacturer->name }}}">{{{ $manufacturer->name }}}</a>
@endforeach
@stop
