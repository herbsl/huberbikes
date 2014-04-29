@extends('layout')

@section('content')
<div class="container">
	<div class="page-header">
		<h1>{{ $title }}</h1>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<div id="carousel-bike" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-bike" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-bike" data-slide-to="1"></li>
					<li data-target="#carousel-bike" data-slide-to="2"></li>
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="/img/bikes/{{{ $bike->id}}}.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				  		<div class="carousel-caption">
							<h3></h3>
					  	</div>
					</div>
					<div class="item">
						<img src="/img/bikes/2.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				  		<div class="carousel-caption">
							<h3></h3>
					  	</div>
					</div>
					<div class="item">
						<img src="/img/bikes/3.jpg" alt="{{{ $bike->manufacturer->name }}} {{{ $bike->name }}}">
				  		<div class="carousel-caption">
							<h3></h3>
					  	</div>
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-bike" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-bike" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>
		<div class="col-sm-5 highlights">
			<div class="row">
				<div class="col-xs-4">
					<strong class="pull-right">Preis</strong>
				</div>
				<div class="col-xs-8">
					@if ( $bike->price_offer != 0 )
					<span class="label label-danger">{{{ $bike->price_offer }}} <span class="glyphicon glyphicon-euro"></span>
					@else
					<span class="label label-default">{{{ $bike->price }}} <span class="glyphicon glyphicon-euro"></span>
					@endif
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<strong class="pull-right">Hersteller</strong>
				</div>
				<div class="col-xs-8">{{{ $bike->manufacturer->name }}}</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<strong class="pull-right">Name</strong>
				</div>
				<div class="col-xs-8">{{{ $bike->name }}}</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<strong class="pull-right">Rahmen</strong>
				</div>
				<div class="col-xs-8">Carbon super-duper</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<strong class="pull-right">Kategorie</strong>
				</div>
				<div class="col-xs-8">
					@foreach($bike->categories as $category)
					<a class="btn btn-default" role="button" href="/bikes/{{{ $category->name }}}">
						{{{ $category->name }}}
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="well">
		{{{ $bike->description }}}
	</div>
</div>
@stop
