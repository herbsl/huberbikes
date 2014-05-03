<?php

class Bike extends Eloquent {
	public function manufacturer() {
		return $this->belongsTo('Manufacturer');
	}

	public function categories() {
		return $this->belongsToMany('Category');
	}

	public function components() {
		return $this->belongsToMany('Component');
	}
}

?>
