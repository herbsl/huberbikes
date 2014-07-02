<?php

class Bike extends Model {
	protected static $rules = array(
		'name' => 'required',
		'price' => 'required',
	);

	protected $softDelete = true;

	public function manufacturer() {
		return $this->belongsTo('Manufacturer');
	}

	public function categories() {
		return $this->belongsToMany('Category');
	}

	public function customers() {
		return $this->belongsToMany('Customer');
	}

	public function components() {
		return $this->belongsToMany('Component');
	}

	public function images() {
		return $this->belongsToMany('Image');
	}

	public function getCustomerNamesAttribute() {
		$customers = array();

		foreach ($this->customers as $customer) {
			array_push($customers, $customer->name);
		}

		return $customers;
	}
}

?>
