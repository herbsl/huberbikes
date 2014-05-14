<?php

class BikeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('bike.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$bike = new Bike();
		$bike->name = Input::get('name');
		$bike->description = Input::get('description');
		$bike->price = Input::get('price');
		$bike->price_offer = Input::get('price_offer');
		$bike->manufacturer_id = Input::get('manufacturer_id');
		$bike->save();

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
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
