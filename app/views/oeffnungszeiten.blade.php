@extends('layout')

@section('content')
<div class="container hb-container">
	<div class="page-header">
		<h1>{{ $title }}</h1>
	</div>
	@include('oeffnungszeiten-content')
</div>
@stop
