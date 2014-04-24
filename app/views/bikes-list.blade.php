@extends('layout')

@section('style')
	.thumbnail-container {
		display: inline-block;
		vertical-align: top;
		padding: 0px 8px 16px 8px;
		width: 100%;

		/* IE7 */
		*zoom: 1;
		*display: inline;
	}

	@media (min-width: 640px) {
  		.thumbnail-container {
    		width: 50%;
  		}
	}

	@media (min-width: 992px) {
  		.thumbnail-container {
    		width: 33.333%;
  		}
	}

	@media (min-width: 1200px) {
  		.thumbnail-container {
    		width: 25%;
  		}
	}

	.thumbnail {
		height: 425px;
		position: relative;
	}

	.label-top-right {
		position: absolute;
		right: 16px;
		top: 0;
	}

	.thumbnail-footer {
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		padding: 16px;
		background-color: #efefef;
	}

	.thumbnail-footer .label {
		font-size: 100%;
	}

	.image-placeholder {
		width: 100%;
		min-height: 200px;
		overflow: hidden;

		text-align: center;
	}

	.image-placeholder img {
		border: 0;
		max-width: 100%;
		max-height: 240px;
	}

	#top-link {
		position: fixed;
		bottom: 16px;
		right: 16px;
	}
@stop

@section('content')
	<div class="container">
		<div class="page-header">
			<h1>{{ $title }}</h1>
		</div>
		@foreach($bikes as $bike)<div class="thumbnail-container">
			<div class="thumbnail">
				@if ( $bike->price_offer != 0 )
				<h3 class="label-top-right"><span class="label label-danger">%</span></h3>
				@else
					@if ( $bike->created_at->diffInDays() < $new_threshold_days )
					<h3 class="label-top-right"><span class="label label-default">Neu</span></h3>
					@endif
				@endif
				<div class="image-placeholder">
					<img src="/images/bikes/{{{ $bike->id}}}-p.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				</div>
				<div class="caption">
					<h3>{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}</h3>
					<p>{{{ $bike->description }}}</p>
					<div class="thumbnail-footer">
						<a href="#" class="btn btn-default" role="button">Details</a>
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

		// Scrolling:
		$('#top-link a').on('click', function() {
			$root.animate({
				scrollTop: 0
			}, 750);

			return false;
		});
	});
@stop
