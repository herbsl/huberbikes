<div class="navbar hb-navbar-secondary" id="navbar-secondary" role="navigation">
	<div class="container-fluid">
		@if (Auth::check())
		<ul class="nav navbar-nav">
			<li>
				<a href="{{{ URL::action('AuthController@logout') }}}" data-singlepage-load="disabled">Abmelden</a>
			</li>
		</ul>
		@endif
		<ul class="nav navbar-nav navbar-right">
			@if (Request::path() === 'kontakt')
			<li class="active">
			@else
			<li>
			@endif
				<a data-toggle="modal" data-target="#modal-contact" data-remote="" href="/kontakt" data-singlepage-load="disabled">Kontakt</a>
			</li>
			@if (Request::path() === 'oeffnungszeiten')
			<li class="active">
			@else
			<li>
			@endif
				<a data-toggle="modal" data-target="#modal-opened" data-remote="" href="/oeffnungszeiten" data-singlepage-load="disabled">&Ouml;ffnungszeiten<!--span class="label label-info" style="margin-left: 4px;vertical-align: top;">Winter</spani--></a>
			</li>
			@if (Request::path() === 'so-finden-sie-uns')
			<li class="active">
			@else
			<li>
			@endif
				<a href="/so-finden-sie-uns">So finden Sie uns</a>
			</li>
			@if (Request::path() === 'datenschutzerklaerung')
			<li class="active">
			@else
			<li>
			@endif
				<a href="/datenschutzerklaerung">Datenschutzerkl&auml;rung</a>
			</li>
			@if (Request::path() === 'impressum')
			<li class="active">
			@else
			<li>
			@endif
				<a href="/impressum">Impressum</a>
			</li>
		</ul>
	</div>
</div>
