<?php

class Asset {
	function __construct() {}

	public function rev($src) {
		$basename = basename($src);
		$dirname = dirname($src);
		$rev = public_path() . $dirname . '/rev-manifest.json';
		if (! file_exists($rev)) {
			return $src;
		}

		$map = json_decode(file_get_contents($rev), true);
		if (! isset($map[$basename])) {
			return $src;
		}

		return $dirname . '/' . $map[$basename];
	}
}

App::singleton('asset', function() {
	return new Asset;
});

?>
