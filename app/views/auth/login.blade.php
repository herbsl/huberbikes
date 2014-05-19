@extends('layout')

@section('content')
<div class="container hb-container">
	@if (Session::has('message'))
	<div class="alert alert-danger">{{{ Session::get('message') }}}</div>
	@endif
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<b>Anmeldung</b>
				</h3>
			</div>
			<div class="panel-body">
				<form role="form" action="/login" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" value="{{{ Input::old('email') }}}" placeholder="Ihre Email Adresse">
					</div>
					<div class="form-group">
						<label for="password">Passwort</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Ihr Passwort">
					</div>
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span> anmelden</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
