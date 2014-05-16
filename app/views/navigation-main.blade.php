<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
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
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="#">Bike-Service Huber</a>
			@else
			<a class="navbar-brand hb-navbar-brand-center hb-text-overflow" href="/">Bike-Service Huber</a>
			@endif
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav navbar-right">
				<li>
					@include('search-form')
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-left">
				@if (substr(Request::path(), 0, 15) === 'bikes/kategorie')
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<a href="/navigation/bikes" class="dropdown-toggle" data-toggle="dropdown">Bikes <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@foreach(Category::all() as $category)
							@if (Request::path() === 'bikes/kategorie/' . $category->name)
							<li class="active">
							@else
							<li>
							@endif
							<a href="/bikes/kategorie/{{{ $category->name }}}">{{{ $category->name }}}</a>
						@endforeach
					</ul>
				</li>
				@if (substr(Request::path(), 0, 16) === 'bikes/hersteller')
				<li class="active dropdown">
				@else
				<li class="dropdown">
				@endif
					<a href="/navigation/hersteller" class="dropdown-toggle" data-toggle="dropdown">Hersteller <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						@foreach(Manufacturer::all() as $manufacturer)
							@if (Request::path() === 'bikes/hersteller/' . $manufacturer->name)
							<li class="active">
							@else
							<li>
							@endif
							<a href="/bikes/hersteller/{{{ $manufacturer->name }}}">{{{ $manufacturer->name }}}</a>
						@endforeach
					</ul>
				</li>
				@if (Request::path() === 'bikes/sale')
				<li class="active">
				@else
				<li>
				@endif
					<a href="/bikes/sale"><b><span class="text-danger">Sale</span></b></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
