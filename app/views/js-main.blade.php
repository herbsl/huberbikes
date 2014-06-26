(function(w, d) {
	'use strict';

	var cb = function() {
		@yield('javascript')
	};

	var f = function() {
		var el = d.createElement("script");
		el.src = Asset.rev('/js/main.min.js');

		if (el.readyState) {
			/* IE */
			el.onreadystatechange = function() {
				if (el.readyState === 'loaded' || el.readyState === 'complete') {
					el.onreadystatechange = null;
					cb();
				}
			}
		}
		else {
			el.onload = cb;
		}

		d.body.appendChild(el);
	};

	if (w.addEventListener) {
		w.addEventListener('load', f, false);
	}
	else if (w.attachEvent) {
		w.attachEvent('onload', f);
	}
	else {
		w.onload = f;
	}
})(window, document);
