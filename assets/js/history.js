(function($, global) {
	'use strict';

	if (Modernizr.history) {
		return;
	}

	$(document).ready(function() {
		var js = Asset.rev('/js/jquery.history.min.js');

		$.ajax({
			url: js,
			dataType: 'script',
			cache: true
		}).done(function() {
			//
		});
	});
})(jQuery, window);
