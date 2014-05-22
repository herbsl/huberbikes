@extends('layout')

@section('content')
<div class="container hb-container">
	@if ($errors->has())
		@foreach ($errors->all() as $message)
		<div class="alert alert-danger">{{ $message }}</div>
		@endforeach
	@endif
	<form class="form-horizontal" action="{{{ $action }}}" method="post" role="form">
		@if (isset($method))
		<input type="hidden" name="_method" value="{{{ $method }}}">
		@endif
		<legend>Bike</legend>
		<fieldset>
			<!-- Name -->
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name des Bikes" value="{{{ Input::old('name', $bike->name) }}}">
				</div>
			</div>
			<!-- Hersteller -->
			<div class="form-group">
				<label for="manufacturer_id" class="col-sm-2 control-label">Hersteller</label>
				<div class="col-sm-4">
					<select class="form-control" id="manufacturer_id" name="manufacturer_id">
						@foreach (Manufacturer::all() as $manufacturer)
							@if ($manufacturer->id === Input::old('manufacturer_id', $bike->manufacturer_id))
							<option value="{{{ $manufacturer->id }}}" selected>{{{ $manufacturer->name }}}</option>
							@else
							<option value="{{{ $manufacturer->id }}}">{{{ $manufacturer->name }}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<!-- Kategorie -->
			<div class="form-group">
				<div class="col-sm-2">
					<span class="pull-right"><b>Kategorie</b></span>
				</div>
				<div class="col-sm-10">
					@foreach (Category::all() as $category)
					<label class="checkbox-inline">
						@if (in_array($category->id, $category_id))
						<input name="category_id[]" type="checkbox" value="{{{ $category->id }}}" checked> {{{ $category->name }}}
						@else
						<input name="category_id[]" type="checkbox" value="{{{ $category->id }}}"> {{{ $category->name }}}
						@endif
					</label>
					@endforeach
				</div>
			</div>
			<!-- Zielgruppe -->
			<div class="form-group">
				<div class="col-sm-2">
					<span class="pull-right"><b>Zielgruppe</b></span>
				</div>
				<div class="col-sm-10">
					@foreach (Customer::all() as $customer)
					<label class="checkbox-inline">
						@if (in_array($customer->id, $customer_id))
						<input name="customer_id[]" type="checkbox" value="{{{ $customer->id }}}" checked> {{{ $customer->name }}}
						@else
						<input name="customer_id[]" type="checkbox" value="{{{ $customer->id }}}"> {{{ $customer->name }}}
						@endif
					</label>
					@endforeach
				</div>
			</div>
			<!-- Preis -->
			<div class="form-group">
				<label for="price" class="col-sm-2 control-label">Preis</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="price" name="price" placeholder="Preis des Bikes" value="{{{ Input::old('price', $bike->price) }}}">
				</div>
			</div>
			<!-- Angebotspreis -->
			<div class="form-group">
				<label for="price_offer" class="col-sm-2 control-label">Angebotspreis</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="price_offer" name="price_offer" placeholder="Angebotspreis des Bikes" value="{{{ Input::old('price_offer', $bike->price_offer) }}}">
				</div>
			</div>
			<!-- Beschreibung -->
			<div class="form-group">
				<label for="description" class="col-sm-2 control-label">Beschreibung</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="description" name="description" rows="5">{{{ Input::old('description', $bike->description) }}}</textarea> 
				</div>
			</div>
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-ok"></span> speichern
				</button>
			</div>
		</div>
		<!--fieldset>
			<legend>Bilder</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">Neu</label>
				<div class="col-sm-10">
					<div id="dropzone" class="dropzone"></div>
				</div>
			</div>
		</fieldset-->
		<fieldset>
			<legend>Komponenten automatisch einlesen</legend>
			<!-- automatische Befuellung -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<textarea class="form-control" id="js-detect-text" rows="5">{{{ Input::old('js-detect-text') }}}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="js-detect-btn" class="btn btn-default" data-singlepage-load="disabled" data-singlepage-prevent="true">
						<span class="glyphicon glyphicon-play"></span> f&uuml;llen
					</button>
					<button type="submit" id="js-delete-btn" class="btn btn-default" data-singlepage-load="disabled" data-singlepage-prevent="true">
						<span class="glyphicon glyphicon-trash"></span> leeren
					</button>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Komponenten</legend>
			<!-- manuelle Befuellung -->
			@foreach(Type::all() as $type)
			<div class="form-group js-detect-input">
				<label for="type-{{{ $type->id }}}" class="col-sm-2 control-label">{{{ $type->name }}}</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="type-{{{ $type->id }}}" name="type-{{{ $type->id }}}" value="{{{ $types[$type->id] }}}" data-keywords="{{{ $type->name . ', ' . $type->keywords }}}">
				</div>
			</div>
			@endforeach
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-ok"></span> speichern
				</button>
			</div>
		</div>
		<fieldset>
			<legend>Bilder</legend>
		</fieldset>
	</form>
	<form action="/api/upload" method="post" class="dropzone">
		<input type="hidden" name="id" value="{{{ $bike->id }}}">
	</form>
</div>
@stop

@section('javascript')
(function($) {
	'use strict';

	var css = Asset.rev('/css/basic.min.css'),
		js = Asset.rev('/js/dropzone.min.js');

	if (document.createStyleSheet){
		document.createStyleSheet(css);
	}
	else {
		$("head").append($("<link rel='stylesheet' type='text/css' href='" + 
			css + "'>"));
	}

	$.ajax({
		url: js,
		dataType: 'script',
		cache: true
	}).then(function() {
		var dropzone = new Dropzone('.dropzone');
	});

	$('#js-detect-btn').click(function(event) {
		var	rawValues = $('#js-detect-text').val();

		$.each(rawValues.split('\n'), function(index, line) {
			var match = line.match(/(Icon:\s.*?\s)*[\s]*([\wÄäÖöÜüß\-\(\)]*)[:\s]*(.*)/);
            if (! match) {
				return;
			}

			var key = match[2],
				value = match[3];

			if (value === '') {
				return;
			}

			$('.js-detect-input input[data-keywords]').each(function() {
				var $this = $(this),
					keywords = $this.data('keywords').split(', ');

				if (jQuery.inArray(key, keywords) != -1) {
					$(this).val(value);
				}
			});
		});
	});

	$('#js-delete-btn').click(function(event) {
		$('.js-detect-input input').each(function() {
			$(this).val('');
		});
	});
})(jQuery);
@stop
