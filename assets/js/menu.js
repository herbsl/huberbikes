(function($) {
	'use strict';

	$('#responsive-menu').click(function(event) {
		// The click should only be triggered without javascript
		event.preventDefault();
	});

	$('.dropdown-toggle').attr('href', '#');
})(jQuery);
