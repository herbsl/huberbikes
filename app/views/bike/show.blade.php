@extends('layout')
@section('content')
<div class="container hb-container">
	<div class="row">
		<div class="col-sm-7 col-md-8">
			<div id="carousel-bike" class="carousel slide" data-interval="false" data-ride="carousel">
				<!-- Indicators -->
				@if (count($bike->images) > 1)
				<ol class="carousel-indicators hb-carousel-indicators">
					@foreach($bike->images as $image)
						@if ($image->default)
						<li data-target="#carousel-bike" data-slide-to="{{{ $image->id }}}" class="active"></li>
						@else
						<li data-target="#carousel-bike" data-slide-to="{{{ $image->id }}}"></li>
						@endif
					@endforeach
				</ol>
				@endif
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					@foreach($bike->images as $image)
						@if ($image->default)
						<div class="item active" data-id="{{{ $image->id }}}">
						@else
						<div class="item" data-id="{{{ $image->id }}}">
						@endif
							<img src="/img/cache/medium/bike/{{{ $bike->id }}}/{{{ $image->name }}}" srcset="/img/cache/medium-2x/bike/{{{ $bike->id }}}/{{{ $image->name }}} 2x" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
						</div>
					@endforeach
				</div>
				<!-- Controls -->
				@if (count($bike->images) > 1)
				<a class="left carousel-control" href="#carousel-bike" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-bike" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
				@endif
			</div>
			<div class="caption">
				<h4>
					<strong>{{{ $title }}}</strong>
				</h4>
				<p>{{{ $bike->description }}}</p>
			</div>
		</div>
		<div class="col-sm-5 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Highlights</strong>
				</div>
				<div class="panel-body">
					<table class="table table-responsive" id="bikes-detail-highlight">
						<tbody>
							@if ( $bike->price_offer != 0 )
							<tr>
								<td>Unverb. Preisempfehlung</td>
								<td class="hb-center-inline">
									<div class="label label-default hb-line-through">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span></div>
								</td>
							</tr>	
							<tr>
								<td>Preis</td>
								<td class="hb-center-inline">
									<div class="label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span></div>
								</td>
							</tr>
							@else
							<tr>
								<td>Preis</td>
								<td class="hb-center-inline">
									<div class="label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span></div>
								</td>
							</tr>
							@endif
							<tr>
								<td>Hersteller</td>
								<td>
									<a class="btn btn-block btn-default" href="{{{ URL::action('bike.index', array('hersteller' => $bike->manufacturer->name)) }}}">{{{ $bike->manufacturer->name }}}</a>
								</td>	
							</tr>
							@foreach($highlights as $highlight)
								@if (! empty($highlight->name))
								<tr>
									<td>{{{ $highlight->type->name }}}</td>
									<td class="hb-center-inline">{{{ $highlight->name }}}</td>
								</tr>
								@endif
							@endforeach
							<tr>
								<td>Kategorie</td>
								<td>
									@foreach($bike->categories as $category)
									<a class="btn btn-block btn-default" href="{{{ URL::action('bike.index', array('kategorie' => $category->name)) }}}">{{{ $category->name }}}</a>
									@endforeach
								</td>
							</tr>
							<tr>
								<td>Zielgruppe</td>
								<td class="hb-center-inline">
									@foreach($bike->customers as $customer)
									{{{ $customer->name }}}
									@endforeach
								</td>
							</tr>
						</tbody>
					</table>
					<div class="row">
						<div class="col-xs-offset-3 col-xs-6 col-sm-offset-2 col-sm-8">
					@if (Auth::check())
						@if (Input::has('trashed') && Input::get('trashed') === 'true')
						<form action="{{{ URL::route('bike.destroy', $bike->id) }}}" role="form" class="hb-margin-top-1x" method="post">
							<input type="hidden" name="_method" value="delete">
							<input type="hidden" name="restore" value="true">
							<button type="submit" class="btn btn-warning btn-block">
								<span class="glyphicon glyphicon-refresh"></span> wiederherstellen 
							</button>
						</form>
						@else
						<a href="{{{ URL::action('bike.edit', $bike->id) }}}" role="button" class="btn btn-default btn-block">
							<span class="glyphicon glyphicon-pencil"></span> bearbeiten
						</a>
						<form action="{{{ URL::route('bike.destroy', $bike->id) }}}" role="form" class="hb-margin-top-1x" method="post">
							<input type="hidden" name="_method" value="delete">
							<button type="submit" class="btn btn-danger btn-block">
								<span class="glyphicon glyphicon-trash"></span> l&ouml;schen
							</button>
						</form>
						@endif
					@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 hb-margin-top-2x">
			<div class="panel panel-default">
				<div class="panel-heading">
					@if ($collapse_details === 'in')
					<a href="?collapse-details=#collapse-btn" data-toggle="collapse" data-target="#collapse-details" class="btn-block" id="collapse-btn" data-singlepage-load="disabled" data-singlepage-prevent="true">
					@else
					<a href="?collapse-details=in#collapse-btn" data-toggle="collapse" data-target="#collapse-details" class="btn-block" id="collapse-btn" data-singlepage-load="disabled" data-singlepage-prevent="true">
					@endif
						<strong>Details</strong> <b class="caret"></b>
					</a>
				</div>
				@if ($collapse_details === 'in')
				<div id="collapse-details" class="panel-collpase collapse in">
				@else
				<div id="collapse-details" class="panel-collpase collapse">
				@endif
					<table class="table table-striped table-responsive">
						<tbody>
			 				@foreach ($bike->components as $component)
								@if (! empty($component->name))	
								<tr>
									<td>{{{ $component->type->name }}}</td>
									<td>{{{ $component->name }}}</td>
								</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('javascript')
$(document).ready(function() {
	'use strict';

	if (! Modernizr.touch) {
		return;
	}

	var $doc = $(document),
		$carousel = $('#carousel-bike');

	var initSwipe = function() {
		$carousel.swipe({
			swipeRight: function(event) {
				$carousel.carousel('prev');
				event.stopPropagation();
			},
			swipeLeft: function(event) {
				$carousel.carousel('next');
				event.stopPropagation();
			}
		});
	};

	if ($.fn.swipe) {
		initSwipe();
	}
	else {
		$doc.on('swipe.load.after', function() {
			initSwipe();
		});
	}
});
@stop
