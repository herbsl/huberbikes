@extends('layout')

@section('content')
<div class="container hb-container">
	<div class="row">
		<div class="col-sm-8">
			<div id="carousel-bike" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-bike" data-slide-to="0" class="active"></li>
					<!--li data-target="#carousel-bike" data-slide-to="1"></li>
					<li data-target="#carousel-bike" data-slide-to="2"></li-->
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<a data-toggle="modal" data-target="#modal-bike" data-remote="" href="#">
							<img src="/img/bikes/{{{ $bike->id}}}.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
						</a>
					</div>
				</div>
				<!-- Controls -->
				<!-- a class="left carousel-control" href="#carousel-bike" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-bike" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a-->
			</div>
			<div class="caption">
				<h4>
					<strong>{{{ $title }}}</strong>
				</h4>
				<p>{{{ $bike->description }}}</p>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Highlights</strong>
				</div>
				<div class="panel-body">
					<table class="table table-responsive" id="bikes-detail-highlight">
						<tbody>
							<tr>
								<td>Preis</td>
								<td>
									@if ( $bike->price_offer != 0 )
									<div class="label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span>
									@else
									<div class="label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span>
									@endif
									</div>
								</td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td>
									<a class="btn btn-default" href="/hersteller/{{{ $bike->manufacturer->name }}}">{{{ $bike->manufacturer->name }}}</a>
								</td>	
							</tr>
							@foreach($highlights as $highlight)
							<tr>
								<td>{{{ $highlight->type->name }}}</td>
								<td>{{{ $highlight->name }}}</td>
							</tr>
							@endforeach
							<tr>
								<td>Kategorie</td>
								<td>
									@foreach($bike->categories as $category)
									<a class="btn btn-default" href="/bikes/{{{ $category->name }}}">{{{ $category->name }}}</a>
									@endforeach
								</td>
							</tr>
						</tbody>
					</table>
					<a href="#" role="button" class="btn btn-success btn-block">Zum Vergleich merken</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 margin-top-2x">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" href="#collapse-details" class="btn-block">
						<strong>Details</strong> <b class="caret"></b>
					</a>
				</div>
				<div id="collapse-details" class="panel-collpase collapse">
					<table class="table table-striped table-responsive">
						<tbody>
			 				@foreach($bike->components as $component)
							<tr>
								<td>{{{ $component->type->name }}}</td>
								<td>{{{ $component->name }}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bottom" id="modal-bike" tabindex="-1" role="dialog" aria-labelledby="modal-bike-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-fs">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<img class="img-responsive" src="/img/bikes/{{{ $bike->id}}}.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
			</div>
		</div>
	</div>
</div>
@stop
