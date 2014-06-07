<?php

class BikeController extends \BaseController {
	function __construct() {
		$this->beforeFilter('auth', array(
			'only' => array(
				'create', 'store', 'edit', 'update'
			)
		));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()	{
		$title = 'Bikes';
		$customer_name = '';
		$query = Bike::query();
		$params = array();
		$order = array('created_at','desc');
		$trashed = $search = false;
		$customers = true;

		if (Auth::check() && Input::has('trashed') && Input::get('trashed') === 'true') {
			$title = 'Papierkorb';
			$trashed = true;
			$params['trashed'] = 'true';

			$query = $query->onlyTrashed();
			$order = array(
				'deleted_at',
				'desc'
			);
		}

		if (Input::has('q')) {
			$q = Input::get('q');
			$title = 'Suche';
			$notfound = 'zu Ihrer Suche';
			$search = true;
			$customers = false;

			foreach(explode(' ', $q) as $queryPart) {
				$query = $query->where(function($query) use ($queryPart) {
					$query->where('name', 'like', '%'. $queryPart . '%')
						->orWhereHas('categories', function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						})->orWhereHas('manufacturer',  function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						})->orWhereHas('customers',  function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						})->orWhereHas('components', function($query) use ($queryPart) {
							$query->where('name', 'like', '%' . $queryPart . '%');
						});
				});
			}
		}
		else {
			$notfound = 'in dieser Kategorie';

			if (Input::has('kategorie')) {
				$category = Input::get('kategorie');
				$title = $category;

				$params['kategorie'] = $category;
				$query = $query->whereHas('categories', function($query) use ($category) {
					$query->where('name', 'like', '%' . $category . '%');
				});

				if ($category === 'Kinderbikes') {
					$customers = false;		
				}
			}

			if (Input::has('hersteller')) {
				$manufacturer = Input::get('hersteller');
				$title = 'Bikes von ' . $manufacturer;

				$params['hersteller'] = $manufacturer;
				$query = $query->whereHas('manufacturer', function($query) use ($manufacturer) {
					$query->where('name', '=', $manufacturer);
				});
			}

			if (Input::has('sale') && Input::get('sale') === 'true') {
				$title = 'Sale';
				$params['sale'] = 'true';

				$query->where('price_offer', '>', 0);
			}

			if (Input::has('zielgruppe')) {
				$customer_name = Input::get('zielgruppe');

				$query = $query->whereHas('customers', function($query) use ($customer_name) {
					$query->where('name', '=', $customer_name);
				});
			}
		}

		$hits = $query->count();

		if ($hits === 0 && $trashed === false) {
			return View::make('bike.empty', array(
	 			'title' => $title,
				'text' => $notfound,
				'params' => $params,
				'customer_name' => $customer_name,
				'customers' => $customers
			));
		}

		if ($hits === 1 && $search) {
			return Redirect::route('bike.show', array(
				$query->first()->id,
				'q' => Input::get('q')
			));
		}

		$query = call_user_func_array(array($query, 'orderBy'), $order);

		return View::make('bike.index', array(
	 		'title' => $title,
			'params' => $params,
			'new_threshold_days' => 90,
			'bikes' => $query->get(),
			'customer_name' => $customer_name,
			'customers' => $customers
		));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$category_id = array();
		$customer_id = array();
		$types = array();

		if (Input::old('category_id')) {
			$category_id = Input::old('category_id');
		}	

		if (Input::old('customer_id')) {
			$customer_id = Input::old('customer_id');
		}	

		foreach (Type::all() as $type) {
			$value = '';
			if (Input::old('type-' . $type->id)) {
				$value = Input::old('type-' . $type->id);
			}
			
			$types[$type->id] = $value;
		}

		return View::make('bike.edit', array(
			'action' => URL::action('bike.store'),
			'bike' => new Bike(),
			'category_id' => $category_id,
			'customer_id' => $customer_id,
			'types' => $types
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			DB::beginTransaction();

			$bike = new Bike();
			$bike->name = Input::get('name');
			$bike->description = Input::get('description');
			$bike->year = Input::get('year');
			$bike->price = Input::get('price');
			$bike->price_offer = Input::get('price_offer');
			$bike->manufacturer_id = Input::get('manufacturer_id');
	
			if (! $bike->save()) {
			   return Redirect::route('bike.create')->withInput()
					->withErrors($bike->getErrors());
			}

			foreach (Input::get('category_id') as $category_id) {
				$bikeCategory = new BikeCategory();
				$bikeCategory->bike_id = $bike->id;
				$bikeCategory->category_id = $category_id;
				$bikeCategory->save();
			}

			foreach (Input::get('customer_id') as $customer_id) {
				$bikeCustomer = new BikeCustomer();
				$bikeCustomer->bike_id = $bike->id;
				$bikeCustomer->customer_id = $customer_id;
				$bikeCustomer->save();
			}

			foreach (Input::all() as $key => $value) {
				$keys = explode('-', $key, 2);
				if ($keys[0] !== 'type') {
					continue;
				}
	
				$component = new Component();
				$component->name = $value;
				$component->type_id = $keys[1];	
				$component->save();
		
				$bikeComponent = new BikeComponent();
				$bikeComponent->bike_id = $bike->id;
				$bikeComponent->component_id = $component->id;
				$bikeComponent->save();
			}
		
			DB::commit();
		}  catch (\PDOException $e) {
    		DB::rollback();
		}

		$url = URL::Action('bike.show', $bike->id);

		return Redirect::to($url)->with('X-Header',
			array('X-Location' => $url));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bike = Bike::query();
		$collapse_details = '';

		if (Auth::check() && Input::has('trashed') && Input::get('trashed') === 'true') {
			$bike = $bike->onlyTrashed();
		}

		if (Input::has('collapse-details')) {
			$collapse_details = Input::get('collapse-details');
		}

		$components = array( 'Farbe', 'Rahmen', 'Bremse', 'Schaltwerk' );
		$bike = $bike->with('categories', 'manufacturer', 'customers', 
			'components')
			->with(array('images' => function($query) {
				$query->orderBy('default', 'desc');
			}))
			->find($id);

		if (! $bike) {
			return View::make('404');
		}

		$highlights = $bike->components->filter(function($component) use ($components) {
			if (in_array($component->type->name, $components)) {
				return true;
			}
	
			return false;
		});

		$defaultImage = $bike->images->filter(function($image) {
			if ($image->default) {
				return true;
			}

			return false;
		})->first();

		return View::make('bike.show', array(
			'title' => $bike->manufacturer->name . ' ' . $bike->name,
			'highlights' => $highlights,
			'bike' => $bike,
			'collapse_details' => $collapse_details,
			'defaultImage' => $defaultImage
		));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bike = Bike::find($id);
		$category_id = array();
		$customer_id = array();
		$types = array();

		if (Input::old('category_id')) {
			$category_id = Input::old('category_id');
		}
		else {
			foreach ($bike->categories as $category) {
				array_push($category_id, $category->id);
			}
		}


		if (Input::old('cumstomer_id')) {
			$customer_id = Input::old('customer_id');
		}
		else {
			foreach ($bike->customers as $customer) {
				array_push($customer_id, $customer->id);
			}
		}

		foreach (Type::all() as $type) {
			$id = $type->id;
			$value = '';
			
			if (Input::old('type-' . $type->id)) {
				$value = Input::old('type-' . $type->id);
			}
			else {	
				$component = $bike->components->filter(function($component) use($id) {
					if ($component->type_id === $id) {
						return true;
					}
				
					return false;
				})->first();

				if ($component) {
					$value = $component->name;
				}
			}
			
			$types[$id] = $value;
		}

		return View::make('bike.edit', array(
			'action' => URL::action('bike.update', $bike->id),
			'method' => 'put',
			'bike' => $bike,
			'category_id' => $category_id,
			'customer_id' => $customer_id,
			'types' => $types
		));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try {
			DB::beginTransaction();

			$bike = Bike::find($id);
			$bike->name = Input::get('name');
			$bike->year = Input::get('year');
			$bike->description = Input::get('description');
			$bike->price = Input::get('price');
			$bike->price_offer = Input::get('price_offer');
			$bike->manufacturer_id = Input::get('manufacturer_id');
	
			if (! $bike->save()) {
			   return Redirect::route('bike.edit', $id)->withInput()
					->withErrors($bike->getErrors());
			}

			BikeCategory::where('bike_id', '=', $bike->id)->delete();
			foreach (Input::get('category_id') as $category_id) {
				$bikeCategory = new BikeCategory();
				$bikeCategory->bike_id = $bike->id;
				$bikeCategory->category_id = $category_id;
				$bikeCategory->save();
			}

			BikeCustomer::where('bike_id', '=', $bike->id)->delete();
			foreach (Input::get('customer_id') as $customer_id) {
				$bikeCustomer = new BikeCustomer();
				$bikeCustomer->bike_id = $bike->id;
				$bikeCustomer->customer_id = $customer_id;
				$bikeCustomer->save();
			}

			BikeComponent::where('bike_id', '=', $bike->id)->delete();
			foreach (Input::all() as $key => $value) {
				$keys = explode('-', $key, 2);
				if ($keys[0] !== 'type') {
					continue;
				}
	
				$component = new Component();
				$component->name = $value;
				$component->type_id = $keys[1];	
				$component->save();
		
				$bikeComponent = new BikeComponent();
				$bikeComponent->bike_id = $bike->id;
				$bikeComponent->component_id = $component->id;
				$bikeComponent->save();
			}
		
			DB::commit();
		}  catch (\PDOException $e) {
    		DB::rollback();
		}

		$url = URL::Action('bike.show', $bike->id);

		return Redirect::to($url)->with('X-Header',
			array('X-Location' => $url));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Input::has('restore') && Input::get('restore') === 'true') {
			Bike::onlyTrashed()->find($id)->restore();
		}
		else {
			Bike::find($id)->delete();
		}

		$url = URL::Action('bike.index');

		return Redirect::to($url)->with('X-Header',
			array('X-Location' => $url));
	}


}
