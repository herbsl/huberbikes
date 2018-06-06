@extends('layout')
@section('content')
<div class="container hb-container">
	<div class="row">
		<div class="col-sm-7 col-md-8">
			@if ($defaultImage)
			<div id="carousel-bike" class="carousel slide" data-interval="false" data-ride="carousel">
				<ol class="carousel-indicators hb-carousel-indicators">
					<li data-target="#carousel-bike" data-slide-to="{{{ $defaultImage->id }}}" class="active"></li></ol>
				<div class="carousel-inner">
					<div class="item hb-item active" data-id="{{{ $defaultImage->id }}}">
						<img src="/img/cache/medium/bike/{{{ Hasher::encrypt($bike->id) }}}/{{{ $defaultImage->name }}}?quality=75" srcset="/img/cache/medium-2x/bike/{{{ Hasher::encrypt($bike->id) }}}/{{{ $defaultImage->name }}}?quality=75 2x" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
					</div>
				</div>
				<a class="left carousel-control" href="#carousel-bike" data-slide="prev">
				</a>
				<a class="right carousel-control" href="#carousel-bike" data-slide="next">
				</a>
			</div>
			@endif
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
							<!--tr>
								<td>Zielgruppe</td>
								<td class="hb-center-inline">
									@foreach($bike->customers as $customer)
									{{{ $customer->name }}}
									@endforeach
								</td>
							</tr-->
						</tbody>
					</table>
					<div class="row">
						<div class="col-xs-offset-3 col-xs-6 col-sm-offset-2 col-sm-8">
					@if (Auth::check())
						@if (Input::has('trashed') && Input::get('trashed') === 'true')
						<form action="{{{ URL::route('bike.destroy', Hasher::encrypt($bike->id)) }}}" role="form" class="hb-margin-top-1x" method="post">
							<input type="hidden" name="_method" value="delete">
							<input type="hidden" name="restore" value="true">
							<button type="submit" class="btn btn-warning btn-block">
								<span class="glyphicon glyphicon-refresh"></span> wiederherstellen 
							</button>
						</form>
						@else
						<a href="{{{ URL::action('bike.edit', Hasher::encrypt($bike->id)) }}}" role="button" class="btn btn-default btn-block">
							<span class="glyphicon glyphicon-pencil"></span> bearbeiten
						</a>
						<form action="{{{ URL::route('bike.destroy', Hasher::encrypt($bike->id)) }}}" role="form" class="hb-margin-top-1x" method="post">
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
(function($, doc) {
	'use strict';

	var $doc = $(doc),
		$carousel = $('#carousel-bike');

	if (! Modernizr.touch) {
		return;
	}

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
})(jQuery, document);

(function($) {
	'use strict';

	var $carouselInner = $('.carousel-inner'),
		$carouselIndicators = $('.carousel-indicators'),
		bike_id = '{{{ Hasher::encrypt($bike->id) }}}';

	var addCarouselImage = function(image) {
		var $div = $(document.createElement('div')),
			$img = $(document.createElement('img')),
			$liIndicator = $(document.createElement('li'));

		$div.addClass('item').attr('data-id', image.id);
		$img.attr('src', '/img/cache/medium/bike/' + bike_id + '/' +
			image.name + '?quality=75');
		$img.attr('srcset', '/img/cache/medium-2x/bike/' + bike_id + '/' +
			image.name + '?quality=75 2x');
		$div.append($img);
		$carouselInner.append($div);

		$liIndicator.attr({
			'data-target': '#carousel-bike',
			'data-slide-to': image.id
		});
		$carouselIndicators.append($liIndicator);
	};

	$.getJSON('/image', {
		'bike_id': bike_id
	}, function(data) {
		$.each(data.images, function(key, value) {
			if (value.default === 0) { 
				addCarouselImage(value);
			}
		});

		if (data.images.length > 1) {
			$('.carousel-control.left').append(	
				$(document.createElement('span'))
					.addClass('glyphicon glyphicon-chevron-left')
			);
			$('.carousel-control.right').append(	
				$(document.createElement('span'))
					.addClass('glyphicon glyphicon-chevron-right')
			);
		}
	});
})(jQuery);
@stop
