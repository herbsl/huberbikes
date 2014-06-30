(function(g, u) {
	g.Asset = g.Asset || {};
	var m = @include('rev-manifest');

	g.Asset.rev = function(f) {
		if('{{{ App::environment('local') }}}') {
			f = f.replace('.min', '');
		}

		if (m[f] !== u) {
			return m[f];
		}

		if (f.charAt(0) === '/') {
			var k = f.substr(1);
			if (m[k]) {
				return '/' + m[k];
			}
		}

		return f;
	};
})(window);
