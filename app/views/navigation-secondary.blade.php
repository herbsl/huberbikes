<div class="navbar hb-navbar-secondary" id="navbar-secondary" role="navigation">
	<div class="container-fluid">
		<ul class="nav navbar-nav navbar-right">
			@if (Request::path() === 'kontakt')
			<li class="active">
			@else
			<li>
			@endif
				<a data-toggle="modal" data-target="#modal-contact" data-remote="" href="/kontakt">Kontakt</a>
			</li>
			@if (Request::path() === 'oeffnungszeiten')
			<li class="active">
			@else
			<li>
			@endif
				<a data-toggle="modal" data-target="#modal-opened" data-remote="" href="/oeffnungszeiten">&Ouml;ffnungszeiten</a>
			</li>
			@if (Request::path() === 'so-finden-sie-uns')
			<li class="active">
			@else
			<li>
			@endif
				<a href="/so-finden-sie-uns">So finden Sie uns</a>
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
