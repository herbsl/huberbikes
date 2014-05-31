<nav class="navbar navbar-default navbar-fixed-top hb-navbar-transparent" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--a onClick="Modernizr.history ? history.back() : History.back(); return false;" class="btn navbar-btn hb-navbar-btn pull-left">
				<span class="sr-only">zur&uuml;ck</span>
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a-->
			<a href="/navigation" id="responsive-menu" class="navbar-toggle hb-navbar-btn" data-toggle="collapse" data-target="#navbar-main" data-singlepage-load="disabled" data-singlepage-prevent="true">
				<span class="sr-only">Men&uuml;</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>	
			</a>
			@if (Request::path() === '/')
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="#" tabindex="1">Huber Bikes</a>
			@else
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="/" tabindex="1">Huber Bikes</a>
			@endif
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav navbar-right">
				<li>
					@include('navigation.search')
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-left">

				@if (Input::has('kategorie'))
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<a href="/navigation/bikes" class="dropdown-toggle" data-toggle="dropdown" tabindex="2">Bikes <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@foreach(Category::all() as $category)
							@if (Input::has('kategorie') && Input::get('kategorie') === $category->name)
							<li class="active">
							@else
							<li>
							@endif
							<a href="{{{ URL::action('bike.index', array('kategorie' => $category->name)) }}}">{{{ $category->name }}}</a>
						@endforeach
					</ul>
				</li>
				@if (Input::has('hersteller'))
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<a href="/navigation/hersteller" class="dropdown-toggle" data-toggle="dropdown" tabindex="3">Hersteller <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@foreach(Manufacturer::all() as $manufacturer)
							@if (Input::has('hersteller') && Input::get('hersteller') === $manufacturer->name)
							<li class="active">
							@else
							<li>
							@endif
							<a href="{{{ URL::action('bike.index', array( 'hersteller' => $manufacturer->name)) }}}">{{{ $manufacturer->name }}}</a>
						@endforeach
					</ul>
				</li>
				@if (Bike::where('price_offer', '>', 0)->count() > 0)
					@if (Input::has('sale') && Input::get('sale') === 'true')
					<li class="active">
					@else
					<li>
					@endif
						<a href="{{{ URL::action('bike.index', array('sale' => 'true')) }}}"><b><span class="text-danger" tabindex="4">Sale</span></b></a>
					</li>
				@endif
				@if (Auth::check())
					@if (Input::has('trashed') && Input::get('trashed') === 'true')
					<li class="active">
					@else
					<li>
					@endif
						<a href="{{{ URL::action('bike.index', array('trashed' => 'true')) }}}" tabindex="5">Papierkorb</a>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
