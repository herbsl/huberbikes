@extends('layout')

@section('content')
<div class="container hb-container">
	<div class="page-header">
		<h1>{{ $title }}</h1>
	</div>
    @if (Auth::check())
	<div class="row hb-margin-bottom-2x">
    	<a href="{{{ URL::action('bike.create') }}}" class="btn btn-success">
			<span class="glyphicon glyphicon-plus"></span> hinzuf&uuml;gen
		</a>
	</div>
    @endif
	@if (Request::path() !== 'bikes/suche')
	<div class="row hb-margin-bottom-2x hb-center-inline">
		<div class="btn-group hb-btn-group">
			@if ($customer_name === '')
			<a href="{{{ URL::action('bike.index', $params) }}}" class="btn btn-default active">Alle</a>
			@else
			<a href="{{{ URL::action('bike.index', $params) }}}" class="btn btn-default">Alle</a>
			@endif

			@foreach(Customer::all() as $customer)
				@if ($customer_name === $customer->name)
				<a href="{{{ URL::action('bike.index', array_merge($params, array('zielgruppe' => $customer->name))) }}}" class="btn btn-default active">{{{ $customer->name }}}</a>
				@else
				<a href="{{{ URL::action('bike.index', array_merge($params, array('zielgruppe' => $customer->name))) }}}" class="btn btn-default">{{{ $customer->name }}}</a>
				@endif
			@endforeach
		</div>
	</div>
	@endif
	<div class="row">
	@foreach($bikes as $bike)<div class="bikes-list-thumbnail-container">
		@if (Input::has('trash') && Input::get('trash') === 'true')
		<a href="{{{ URL::action('bike.show', array($bike->id, 'trash' => 'true')) }}}" role="button">
		@else
		<a href="{{{ URL::action('bike.show', $bike->id) }}}" role="button">
		@endif
			<div class="thumbnail">
				@if ( $bike->price_offer != 0 )
				<h3 class="label-top-right">
					<span class="label label-danger">%</span></h3>
				@else
					@if ( $bike->created_at->diffInDays() < $new_threshold_days )
					<h3 class="label-top-right">
						<span class="label label-default">Neu</span>
					</h3>
					@endif
				@endif
				<div class="image-placeholder">
					<img src="/img/bikes/{{{ $bike->id}}}.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				</div>
				<div class="caption">
					<h4>
						<strong>{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}</strong>
					</h4>
					<p>{{{ $bike->description }}}</p>
					<div class="thumbnail-footer">
						<span class="btn btn-default">Details</span>
						@if ( $bike->price_offer != 0 )
						<div class="pull-right label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span>
						@else
						<div class="pull-right label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span>
						@endif
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>@endforeach
	</div>
</div>
<div id="top-link">
	<a href="#" role="button" class="btn btn-default">
		<span class="glyphicon glyphicon-chevron-up"></span>
	</a>
</div>
@stop

@section('javascript')
	$(document).ready(function() {
		var $root = $('html, body');

		$('#top-link a').on('click', function() {
			$root.animate({
				scrollTop: 0
			}, 750);

			return false;
		});
	});
@stop
