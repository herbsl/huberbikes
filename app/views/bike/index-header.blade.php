<div class="page-header">
	<div class="row">
		<div class="col-sm-10">
		<h1>{{{ $title }}}</h1>
		</div>
		<div class="col-sm-2">	
		@if (Auth::check())
   		<a href="{{{ URL::action('bike.create') }}}" class="btn btn-success">
			<span class="glyphicon glyphicon-plus"></span> hinzuf&uuml;gen
		</a>
		@endif
		</div>
	</div>
</div>
@if ($show_customers === true)
<div class="row hb-margin-bottom-2x hb-center-inline">
	<div class="btn-group hb-btn-group">
		@if ($active_customer === '')
		<a href="{{{ URL::action('bike.index', $params) }}}" class="btn btn-default active">Alle</a>
		@else
		<a href="{{{ URL::action('bike.index', $params) }}}" class="btn btn-default">Alle</a>
		@endif
		@foreach(Customer::all() as $customer)
			@if ($active_customer === $customer->name)
			<a href="{{{ URL::action('bike.index', array_merge($params, array('zielgruppe' => $customer->name))) }}}" class="btn btn-default active">{{{ $customer->name }}}</a>
			@else
			<a href="{{{ URL::action('bike.index', array_merge($params, array('zielgruppe' => $customer->name))) }}}" class="btn btn-default">{{{ $customer->name }}}</a>
			@endif
		@endforeach
	</div>
</div>
@endif
