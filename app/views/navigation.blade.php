<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="/responsive-menu" id="responsive-menu" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-main">
				<span class="sr-only">Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>	
			</a>
			@if (Request::path() === '/')
			<a class="navbar-brand" href="#">Bike-Service Huber</a>
			@else
			<a class="navbar-brand" href="/">Bike-Service Huber</a>
			@endif
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<form class="navbar-form" action="/bikes/suche" role="search">
						<div class="input-group input-form">
							<input type="text" name="q" id="navbar-search" class="form-control" placeholder="Bikes suchen ..." autocomplete="off">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</div>
						</div>
					</form>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-left">
				@if (substr(Request::path(), 0, 5) === 'bikes')
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<a href="/bikes" class="dropdown-toggle" data-toggle="dropdown">Bikes <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@if (Request::path() === 'bikes/mountain')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/bikes/mountain">Mountainbikes</a>
						</li>
						@if (Request::path() === 'bikes/active')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/bikes/active">Activebikes</a>
						</li>
						@if (Request::path() === 'bikes/elektro')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/bikes/elektro">E-Bikes</a>
						</li>
					    <li class="divider hidden-xs"></li>
						@if (Request::path() === 'bikes/kinder')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/bikes/kinder">Kinderbikes</a>
						</li>
						@if (Request::path() === 'bikes/jugendliche')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/bikes/jugendliche">f&uuml;r Jugendliche</a>
						</li>
					</ul>
				</li>
				@if (substr(Request::path(), 0, 5) === 'bikes')
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<!--a href="/hersteller" class="dropdown-toggle" data-toggle="dropdown">Hersteller <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@if (Request::path() === '/hersteller/simplon')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/hersteller/simplon">Simplon</a>
						</li>
						@if (Request::path() === 'hersteller/focus')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/hersteller/focus">Focus</a>
						</li>
						@if (Request::path() === 'hersteller/merida')
						<li class="active">
						@else
						<li>
						@endif
							<a href="/hersteller/merida">Merida</a>
						</li>
					</ul-->
				</li>
				@if (Request::path() === 'sale')
				<li class="active">
				@else
				<li>
				@endif
					<a href="/sale"><b><span class="text-danger">Sale</span></b></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
@if (Request::path() === '/' || Request::path() === 'so-finden-sie-uns' || Request::path() === 'impressum' || Request::path() === 'kontakt' || Request::path() === 'oeffnungszeiten')
<nav class="navbar navbar-default navbar-fixed-bottom hidden-xs" id="navbar-add" role="navigation">
@else
<nav class="navbar navbar-default navbar-fixed-bottom hidden hidden-xs" id="navbar-add" role="navigation">
@endif
	<div class="container">
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
</nav>
