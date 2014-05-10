<?php

function getBikesListView($bikes, $title) {
	$customer = '';

	if (Input::has('kunde')) {
		$customer = Input::get('kunde');
		$bikes = $bikes->whereHas('customers', function($query) use ($customer) {
			$query->where('name', '=', $customer);
		});
	}

	$bikes = $bikes->get();

	if ($bikes->count() === 1 && Request::path() === 'bikes/suche') {
		return getBikesDetailView($bikes->first()->id);
	}

	return View::make('bikes-list', array(
 		'title' => $title,
		'new_threshold_days' => 30,
		'bikes' => $bikes,
		'customer_name' => $customer,
	));
}

function getBikesDetailView($id) {
	$maxLastViewed = 5;
	$collapse_details = '';

	if (Input::has('collapse-details')) {
		$collapse_details = Input::get('collapse-details');
	}

	$components = array( 'Farbe', 'Rahmen', 'Bremsen', 'Schaltwerk' );
	$bike = Bike::with('categories')->with('manufacturer')->with('customers')->with('components')->find($id);

	$highlights = $bike->components->filter(function($component) use ($components) {
		if (in_array($component->type->name, $components)) {
			return true;
		}

		return false;
	});

	/*$lastViewed = (array)Session::get('last:viewed');
	$countLastViewed = count($lastViewed);
	$lastViewedOrderedBikes = array();

	if ($countLastViewed > 0) {
		$lastViewedOrder = array_diff(
			$lastViewed, array( $id )
		);

		$lastViewedBikes = Bike::whereIn('id', 
			array_slice(
				$lastViewedOrder,
				0, $maxLastViewed)
			)->with('manufacturer')->get();
		foreach ($lastViewedOrder as $value) {
			$tmp = $lastViewedBikes->find($value);
			if ($tmp) {
				array_push($lastViewedOrderedBikes, $tmp);
			}
		}
	}*/

	$view = View::make('bikes-detail', array(
		'title' => $bike->manufacturer->name . ' ' . $bike->name,
		'highlights' => $highlights,
		'bike' => $bike,
		'collapse_details' => $collapse_details
		/*'new_threshold_days' => 30,
		'lastViewedBikes' => $lastViewedOrderedBikes*/
	));

	/*array_unshift($lastViewed, $id);
	Session::set('last:viewed', 
		array_slice(
			array_unique($lastViewed),
			0,  $maxLastViewed + 1
		)
	);*/

	return $view;
}

Route::get('/navigation', function() {
	return View::make('navigation.main', array(
		'title' => 'Navigation'
	));
});

Route::get('/', function() {
	return View::make('start');
});

Route::get('/navigation/bikes', function() {
	return View::make('navigation.bikes');
});

Route::get('/navigation/hersteller', function() {
	return View::make('navigation.hersteller');
});

Route::get('/bikes/hersteller/{name}', function($name) {
	$title = ucwords(strtolower($name));

	$bikes = Bike::whereHas('manufacturer', function($query) use ($name) {
		$query->where('name', '=', $name);	
	})->with('categories');

	return getBikesListView($bikes, $title);
});

Route::get('/bikes/detail/{id}', function($id) {
	return getBikesDetailView($id);
});


Route::get('/bikes/suche', function() {
	$q = '';
	$bikes = null;
	$title = '';

	if (Input::has('q')) {
		$q = Input::get('q');
		$title = ucwords(strtolower($q));
	}

	foreach(explode(' ', $q) as $queryPart) {
		if (is_null($bikes)) {
			$bikes = Bike::where(function($query) use ($queryPart) {
				$query->where('name', 'like', '%'. $queryPart . '%')
					->orWhereHas('categories', function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					})->orWhereHas('manufacturer',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					})->orWhereHas('customers',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
				});
			});
		} else {
			$bikes = $bikes->where(function($query) use ($queryPart) {
				$query->where('name', 'like', '%'. $queryPart . '%')
					->orWhereHas('categories', function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					})->orWhereHas('manufacturer',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					})->orWhereHas('customers',  function($query) use ($queryPart) {
						$query->where('name', 'like', '%' . $queryPart . '%');
					});
			});
		}
	}

	return getBikesListView($bikes, $title);
});

Route::get('/bikes/kategorie/{category}', function($category) {
	$category = urldecode(strtolower($category));
	$title = ucwords($category);

	$bikes = Bike::whereHas('categories', function($query) use ($category) {
		$query->where('name', 'like', '%' . $category . '%');
	});

	if (Input::has('kunde')) {
		$customer = Input::get('kunde');
		$bikes = $bikes->whereHas('customers', function($query) use ($customer) {
			$query->where('name', '=', $customer);
		});
	}

	return getBikesListView($bikes, $title);
});


Route::get('/bikes/sale', function() {
	$bikes = Bike::where('price_offer', '!=', '0')
		->with('categories')->with('manufacturer');

	return getBikesListView($bikes, 'Sale');
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

	foreach (Customer::get() as $category) {
		array_push($suggestions, $category->name);
	}

	$bikes = Bike::with('manufacturer')->get();
	foreach ($bikes as $bike) {
		array_push($suggestions, $bike->manufacturer->name . ' ' . $bike->name);
	}

	return Response::json($suggestions);
});
