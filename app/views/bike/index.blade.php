@extends('layout')

@section('content')
<div class="container hb-container">
	@include('bike.index-header')
	<div class="row">
	@foreach($bikes as $bike)<div class="bikes-list-thumbnail-container">
		@if (Input::has('trashed') && Input::get('trashed') === 'true')
		<a href="{{{ URL::action('bike.show', array($bike->id, 'trashed' => 'true')) }}}" role="button">
		@else
		<a href="{{{ URL::action('bike.show', $bike->id) }}}" role="button">
		@endif
			<div class="thumbnail">
				@if ( $bike->price_offer != 0 )
				<h3 class="label-top-right">
					<span class="label label-danger">%</span></h3>
				@else
					@if ($bike->created_at->diffInDays() < $new_threshold_days )
					<h3 class="label-top-right">
						<span class="label label-default">Neu</span>
					</h3>
					@endif
				@endif
				<div class="image-placeholder">
					@foreach ($bike->images as $image)
						@if ($image->default)
						<img src="/img/cache/x-small/bike/{{{ $bike->id }}}/{{{ $image->name }}}?quality=75" srcset="/img/cache/x-small-2x/bike/{{{ $bike->id }}}/{{{ $image->name }}}?quality=75 2x" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
						@endif
					@endforeach
				</div>
				<div class="caption">
					<h4>
						<strong>{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}</strong>
					</h4>
					<p>{{{ $bike->description }}}</p>
					<div class="thumbnail-footer">
						<span class="btn btn-default">Details</span>
						@if ( $bike->price_offer != 0 )
						<div class="pull-right label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span></div>
						<div class="pull-right label label-default hb-line-through">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span></div>
						@else
						<div class="pull-right label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span></div>
						@endif
					</div>
				</div>
			</div>
		</a>
	</div>@endforeach
	</div>
</div>
@stop
