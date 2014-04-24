<?php

class Bike extends Eloquent {
	public function manufacturer() {
		return $this->belongsTo('Manufacturer');
	}

	public function categories() {
		return $this->belongsToMany('Category');
	}
}

?>
