<?php

class Component extends Eloquent {
	public function type() {
		return $this->belongsTo('Type');
	}
}

?>
