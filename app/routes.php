<?php

Route::get('/responsive-menu', function() {
	return View::make('responsive-menu', array(
		'title' => 'Men&uuml;'
	));
});

Route::get('/', function() {
	return View::make('start', array(
		'cssClass' => 'start-page'
	));
});

Route::get('/bikes', function() {
	return View::make('bikes', array(
		'title' => 'Bikes'
	));
});

Route::get('/hersteller/{name}', function($name) {
	$bikes = Bike::whereHas('manufacturer', function($query) use ($name) {
		$query->where('name', '=', $name);	
	})->with('categories')->get();	

	return View::make('bikes-list', array(
		'title' => $name,
		'new_threshold_days' => 30,
	))->with('bikes', $bikes);	
});

Route::get('/bikes/detail/{id}', function($id) {
	$bike = Bike::with('categories')->with('manufacturer')->find($id);

	return View::make('bikes-detail', array(
		'title' => $bike->manufacturer->name . ' ' . $bike->name,
	))->with('bike', $bike);
});

Route::get('/bikes/{category}', function($category) {
	$category = strtolower($category);
	$title = ucfirst($category);

	switch ($category) {
		case 'all':
			$bikes = Bike::with('categories')->with('manufacturer')->get();
			break;

		case 'suche':
			$q = '';
			$bikes = null;
			$titleArray = array();

			if (Input::has('q')) {
	            $q = Input::get('q');
				$title = $q;
	        }

			foreach(explode(' ', $q) as $queryPart) {
				if (is_null($bikes)) {
					$bikes = Bike::whereHas('categories', function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					})->orWhereHas('manufacturer',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					});
				} else {
					$bikes = $bikes->whereHas('categories', function($query) use ($category) {
						$query->where('name', 'like', '%' . $category . '%');
					})->orWhereHas('manufacturer',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					});
				}
			}

			$bikes = $bikes->with('manufacturer')->get();
			break;		

		default:
			$bikes = Bike::whereHas('categories', function($query) use ($category) {
				$query->where('name', '=', $category);	
			})->with('manufacturer')->get();	
	}

	return View::make('bikes-list', array(
		'title' => $title,
		'new_threshold_days' => 30,
	))->with('bikes', $bikes);
});

Route::get('/sale', function() {
	$bikes = Bike::where('price_offer', '!=', '0')
		->with('categories')->with('manufacturer')->get();

	return View::make('bikes-list', array(
		'title' => 'Sale',
		'new_threshold_days' => 30,
	))->with('bikes', $bikes);
});

Route::get('/kontakt', function() {
	return View::make('kontakt', array(
		'title' => 'Unsere Kontaktdaten'
	));
});

Route::get('/oeffnungszeiten', function() {
	return View::make('oeffnungszeiten', array(
		'title' => 'Unsere &Ouml;ffnungszeiten'
	));
});

Route::get('/so-finden-sie-uns', function() {
	return View::make('so-finden-sie-uns', array(
		'title' => 'So finden Sie uns'
	));
});

Route::get('/impressum', function() {
	return View::make('impressum', array(
		'title' => 'Impressum'
	));
});

Route::get('/api/suggestions', function() {
	$suggestions = array();
	foreach (Manufacturer::get() as $manufacturer) {
		array_push($suggestions, $manufacturer->name);
	}

	foreach (Category::get() as $category) {
		array_push($suggestions, $category->name);
	}

	$bikes = Bike::with('manufacturer')->get();
	foreach ($bikes as $bike) {
		array_push($suggestions, $bike->manufacturer->name . ' ' . $bike->name);
	}

	return Response::json($suggestions);
});
