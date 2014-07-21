<?php

namespace Herbsl\Hasher;

use Mitch\Hashids\Hashids;

class Hasher {
	private $threshold;

	function __construct() {
		$this->threshold = 62;
	}

	public function encrypt($id) {
		if ((int)$id <= $this->threshold) {
			return $id;
		}

		return Hashids::encrypt($id);
	}

	public function decrypt($id) {
		if (is_numeric($id) && (int)$id <= $this->threshold) {
			return $id;
		}

		$hashids = Hashids::decrypt($id);
		if (count($hashids) > 0) {
			return $hashids[0];
		}

		return -1;
	}
}

?>
