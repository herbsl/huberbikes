<?php

Route::resource('bike', 'BikeController');

function getBikesListView($bikes, $title) {
	$customer = '';

	if (Input::has('zielgruppe')) {
		$customer = Input::get('zielgruppe');
		$bikes = $bikes->whereHas('customers', function($query) use ($customer) {
			$query->where('name', '=', $customer);
		});
	}

	$bikes = $bikes->get();

	if ($bikes->count() === 1 && Request::path() === 'bikes/suche') {
		return getBikesDetailView($bikes->first()->id);
	}

	return View::make('bike.index', array(
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

	$view = View::make('bike.show', array(
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

Route::get('/admin/bikes/neu', function() {
	return View::make('admin.bikes-new');
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


Route::get('/image', function() {
	if (! Input::has('bike_id')) {
		return Response::json(array(
			'error' => 'Missing parameter'
		), 400);
	}

	$bike_id = Input::get('bike_id');
	$bike = Bike::with('images')->find($bike_id);

	if ($bike) {
		return Response::json(array(
			'success' => '',
			'images' => $bike->images->toArray()
		));
	}
});

Route::post('/image', function() {
	if (! Input::hasFile('file') || ! Input::has('bike_id')) {
		return Response::json(array(
			'error' => 'Missing parameter'
		), 400);
	}

	$bike_id = Input::get('bike_id');
	$file = Input::file('file');

	$path = public_path() . '/img/bike/' . $bike_id;
	if (! is_dir($path) && ! mkdir($path, 0777, true)) {
		return Response::json(array(
			'error' => 'Could not create the target directory'
		), 500);
	}

	$name = md5_file($file->getRealPath()) . '.' .
		strtolower($file->getClientOriginalExtension());
	$size = $file->getSize();
	$file->move($path, $name);

	$hasDefault = Bike::find($bike_id)->whereHas('images', function($query) {
		$query->where('default', '=', 1);
	});

	$image = new Image();
	$image->name = $name;
	$image->size = $size;
	$image->default = $hasDefault->count() > 0 ? false : true;
	$image->save();

	$bikeImage = new BikeImage();
	$bikeImage->bike_id = $bike_id;
	$bikeImage->image_id = $image->id;
	$bikeImage->save();

	return Response::json(array(
		'success' => '',
		'image' => $image->toArray()
	));
});

Route::put('/image/{id}', function($image_id) {
	if (! Input::has('bike_id')) {
		return Response::json(array(
			'error' => 'Missing parameter'
		), 400);
	}

	$bike_id = Input::get('bike_id');
	$bike = Bike::with('images')->find($bike_id);

	foreach ($bike->images as $image) {
		/*if ($image->id == $image_id) {
			$image->default = true;
		}
		else {*/
			$image->default = false;
		//}
	}

	$bike->push();
	$image = Image::find($image_id);
	$image->default = 1;
	$image->save();

	return Response::json(array(
		'success' => ''
	));
});

Route::delete('/image/{id}', function($image_id) {
	if (! Input::has('bike_id')) {
		return Response::json(array(
			'error' => 'Missing parameter'
		), 400);
	}

	$bike_id = Input::get('bike_id');
	$image = Image::find($image_id);
	$path = public_path() . '/img/bike/' . $bike_id . '/' . $image->name;
	if (is_file($path)) {
		unlink($path);
	}
	$image->delete();

	return Response::json('success');
});


Route::get('/login', 'AuthController@show');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
