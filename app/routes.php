<?php

function getBikesListView($bikes, $title) {
	switch($bikes->count()) {
		case 0:
			// TODO
			break;
		case 1:
			return getBikesDetailView($bikes->first()->id);
			break;

		default:
			return View::make('bikes-list', array(
		 		'title' => $title,
				'new_threshold_days' => 30,
				'bikes' => $bikes
			));
	}
}

function getBikesDetailView($id) {
	$maxLastViewed = 5;

	$components = array( 'Farbe', 'Rahmen', 'Bremsen', 'Schaltwerk' );
	$bike = Bike::with('categories')->with('manufacturer')->with('components')->find($id);

	$highlights = $bike->components->filter(function($component) use ($components) {
		if (in_array($component->type->name, $components)) {
			return true;
		}

		return false;
	});

	$lastViewed = (array)Session::get('last:viewed');
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
	}

	$view = View::make('bikes-detail', array(
		'title' => $bike->manufacturer->name . ' ' . $bike->name,
		'highlights' => $highlights,
		'bike' => $bike,
		'new_threshold_days' => 30,
		'lastViewedBikes' => $lastViewedOrderedBikes
	));

	array_unshift($lastViewed, $id);
	Session::set('last:viewed', 
		array_slice(
			array_unique($lastViewed),
			0,  $maxLastViewed + 1
		)
	);

	return $view;
}

Route::get('/responsive-menu', function() {
	return View::make('responsive-menu', array(
		'title' => 'Men&uuml;'
	));
});

Route::get('/', function() {
	return View::make('start');
});

Route::get('/bikes', function() {
	return View::make('bikes', array(
		'title' => 'Bikes'
	));
});

Route::get('/hersteller/{name}', function($name) {
	$title = ucfirst($name);

	$bikes = Bike::whereHas('manufacturer', function($query) use ($name) {
		$query->where('name', '=', $name);	
	})->with('categories')->get();

	return getBikesListView($bikes, $title);
});

Route::get('/bikes/detail/{id}', function($id) {
	return getBikesDetailView($id);
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
					$bikes = Bike::where(function($query) use ($queryPart) {
						$query->where('name', 'like', '%'. $queryPart . '%')
						->orWhereHas('categories', function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						})
						->orWhereHas('manufacturer',  function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						});
					});
				} else {
					$bikes = $bikes->where(function($query) use ($queryPart) {
						$query->where('name', 'like', '%'. $queryPart . '%')
						->orWhereHas('categories', function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						})
						->orWhereHas('manufacturer',  function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						});
					});
				}
			}

			$bikes = $bikes->get();
			break;		

		default:
			$bikes = Bike::whereHas('categories', function($query) use ($category) {
				$query->where('name', '=', $category);	
			})->with('manufacturer')->get();	
	}

	return getBikesListView($bikes, $title);
});

Route::get('/sale', function() {
	$bikes = Bike::where('price_offer', '!=', '0')
		->with('categories')->with('manufacturer')->get();

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

	$bikes = Bike::with('manufacturer')->get();
	foreach ($bikes as $bike) {
		array_push($suggestions, $bike->manufacturer->name . ' ' . $bike->name);
	}

	return Response::json($suggestions);
});
