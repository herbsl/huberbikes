@extends('layout')

@section('content')
<div class="container hb-container">
	<div class="page-header">
		<h1>{{ $title }}</h1>
	</div>
	@foreach($bikes as $bike)<div class="bikes-list-thumbnail-container">
		<div class="thumbnail">
			@if ( $bike->price_offer != 0 )
			<h3 class="label-top-right"><span class="label label-danger">%</span></h3>
			@else
				@if ( $bike->created_at->diffInDays() < $new_threshold_days )
				<h3 class="label-top-right"><span class="label label-default">Neu</span></h3>
				@endif
			@endif
			<div class="image-placeholder">
				<a href="/bikes/detail/{{{ $bike->id }}}">
					<img src="/img/bikes/{{{ $bike->id}}}.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				</a>
			</div>
			<div class="caption">
				<h4>
					<strong>{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}</strong>
				</h4>
				<p>{{{ $bike->description }}}</p>
				<div class="thumbnail-footer">
					<a href="/bikes/detail/{{{ $bike->id }}}" class="btn btn-default" role="button">Details</a>
					@if ( $bike->price_offer != 0 )
					<span class="pull-right label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span>
					@else
					<span class="pull-right label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span>
					@endif
					</span>
				</div>
			</div>
		</div>
	</div>@endforeach
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
