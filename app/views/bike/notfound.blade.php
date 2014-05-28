@extends('layout')

@section('content')
<div class="container hb-container hb-font-size-md">
	@include('bike.index-header')
	<p>Leider haben wir zu {{{ $text }}} keinen passenden Artikel in unserem Online Sortiment.</p>
	<p>In unserem Ladengesch&auml;ft bieten wir Ihnen eine erweiterte Auswahl. Wir freuen uns, von Ihnen zu h&ouml;ren.</p>
</div>
@stop
