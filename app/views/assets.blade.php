(function(g, u) {
	g.Asset = g.Asset || {};
	g.Asset.js = @include('rev-manifest-js');
	g.Asset.css = @include('rev-manifest-css');

	g.Asset.rev = function(f) {
		if (g.Asset.js[f] !== u) {
			return g.Asset.js[f];
		}
		if (g.Asset.css[f]) {
			return g.Asset.css[f];
		}

		return f;
	};
})(window);
