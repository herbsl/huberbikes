(function($) {
	'use strict';

	if (! Modernizr.touch) {
		return;
	}

	var $navbarSearch = $('#navbar-search');
	
	var touchmoveEvent = function(event) {
		$target = $(event.target);

		if ($target.closest('.navbar-form').length === 0) { 
			$navbarSearch.blur();
		}
	};
	
	// Fix fixed scrollbar in Webkit
	$navbarSearch.focus(function(event) {
		if ($(document).scrollTop() !== 0) {
			$('.navbar-fixed-top').addClass('fix-fixed');
			$('.navbar-fixed-top').css('top', $(document).scrollTop());

			window.setTimeout(function() {
				$('html, body').scrollTop($('.navbar-fixed-top').offset().top);
			}, 150);
		}

		$(document).on('touchmove', touchmoveEvent);
	});

	$navbarSearch.blur(function(event) {
		$('.navbar-fixed-top').removeClass('fix-fixed');
		$('.navbar-fixed-top').css('top', 'none');
		$(document).off('touchmove', touchmoveEvent);
	});

	// Load Fastclick
	$.ajax({
		url: '/js/fastclick.min.js',
		dataType: 'script',
		cache: true
	}).done(function() {
		FastClick.attach(document.body);
	});
})(jQuery);
