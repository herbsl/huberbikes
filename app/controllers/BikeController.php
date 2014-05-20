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
	public function index()
	{
		$title = 'Bikes';
		$customers = '';
		$query = Bike::query();
		$params = array();

		if (Input::has('trash') && Input::get('trash') === 'true') {
			$title .= ': Papierkorb';
			$query = $query->onlyTrashed();
		}

		if (Input::has('kategorie')) {
			$category = Input::get('kategorie');
			$params['kategorie'] = $category;

			$query = $query->whereHas('categories', function($query) use ($category) {
				$query->where('name', 'like', '%' . $category . '%');
			});
		}

		if (Input::has('hersteller')) {
			$manufacturer = Input::get('hersteller');
			$params['hersteller'] = $manufacturer;

			$query = $query->whereHas('manufacturer', function($query) use ($manufacturer) {
				$query->where('name', '=', $manufacturer);
			});
		}

		if (Input::has('sale') && Input::get('sale') === 'true') {
			$params['sale'] = 'true';

			$query->where('price_offer', '>', 0);
		}

		if (Input::has('zielgruppe')) {
			$customers = Input::get('zielgruppe');
			$query = $query->whereHas('customers', function($query) use ($customers) {
				$query->where('name', '=', $customers);
			});
		}

		if ($query->count() === 1 && Request::path() === 'bikes/suche') {
			return Redirect::route('bike.show', $query->first()->id);
		}

		return View::make('bike.index', array(
	 		'title' => $title,
			'new_threshold_days' => 30,
			'bikes' => $query->get(),
			'customer_name' => $customers,
			'params' => $params
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

		return Redirect::route('bike.index');
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

		if (Auth::check() && Input::has('trash') && Input::get('trash') === 'true') {
			$bike = $bike->withTrashed();
		}

		if (Input::has('collapse-details')) {
			$collapse_details = Input::get('collapse-details');
		}

		$components = array( 'Farbe', 'Rahmen', 'Bremsen', 'Schaltwerk' );
		$bike = $bike->with('categories', 'manufacturer', 'customers', 
			'components')->find($id);

		$highlights = $bike->components->filter(function($component) use ($components) {
			if (in_array($component->type->name, $components)) {
				return true;
			}
	
			return false;
		});

		return View::make('bike.show', array(
			'title' => $bike->manufacturer->name . ' ' . $bike->name,
			'highlights' => $highlights,
			'bike' => $bike,
			'collapse_details' => $collapse_details
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

		return Redirect::route('bike.index');
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

		return Redirect::route('bike.index');
	}


}
