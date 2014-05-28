<form class="navbar-form" action="{{{ URL::action('bike.index') }}}" role="search">
	<div class="input-group input-form">
		<input type="text" name="q" id="navbar-search" class="form-control" placeholder="Bikes suchen ..." autocomplete="off" tabindex="6" value="{{{ Input::get('q') }}}">
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default" tabindex="7">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</div>
	</div>
</form>
