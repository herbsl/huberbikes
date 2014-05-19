@extends('navigation.base')

@section('navigation-items')
@foreach (Category::all() as $category)
	<a class="list-group-item" href="{{{ URL::action('bikes.index', array('kategorie' => $category->name)) }}}">{{{ $category->name }}}</a>
@endforeach
@stop
