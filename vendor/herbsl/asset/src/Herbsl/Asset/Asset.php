<?php

namespace Herbsl\Asset;

use Illuminate\Support\Facades\App;

class Asset {
	function __construct() {}

	public function rev($src) {
		if (App::environment('local')) {
			$src = str_replace('.min', '', $src);
		}

		$rev = public_path() . '/rev-manifest.json';
		if (! file_exists($rev)) {
			return $src;
		}

	
		$map = json_decode(file_get_contents($rev), true);
		if (isset($map[$src])) {
			return $map[$src];
		}

		if (substr($src, 0, 1) === '/') {
			$key = substr($src, 1);
			if (isset($map[$key])) {
				return '/' . $map[$key];
			}
		}

		return $src;
	}
}

?>
