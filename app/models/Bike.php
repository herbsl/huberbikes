<?php

class Bike extends Model {
	protected static $rules = array(
		'name' => 'required|min:5',
		'price' => 'required'
	);

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
}

?>
