<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="javascript:history.back();" class="btn navbar-btn hb-navbar-btn pull-left">
				<span class="sr-only">zur&uuml;ck</span>
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a href="/responsive-menu" id="responsive-menu" class="navbar-toggle hb-navbar-btn" data-toggle="collapse" data-target="#navbar-main">
				<span class="sr-only">Men&uuml;</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>	
			</a>
			@if (Request::path() === '/')
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="#">Bike-Service Huber</a>
			@else
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="/">Bike-Service Huber</a>
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
