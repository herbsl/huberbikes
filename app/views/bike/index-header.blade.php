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
@if ($search === false)
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
