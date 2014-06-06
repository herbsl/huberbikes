(function($, doc) {
	'use strict';
	
	if (! Modernizr.touch) {
		return;
	}

	var $doc = $(doc),
		$navbarSearch = $('#navbar-search');

	$('html').addClass('touch');
	
	/* Fix fixed scrollbar in Webkit */
	var touchmoveEvent = function(event) {
		$target = $(event.target);

		if ($target.closest('.navbar-form').length === 0) { 
			$navbarSearch.blur();
		}
	};

	$navbarSearch.focus(function(event) {
		if ($doc.scrollTop() !== 0) {
			$('.navbar-fixed-top').addClass('fix-fixed');
			$('.navbar-fixed-top').css('top', $doc.scrollTop());

			window.setTimeout(function() {
				$('html, body').scrollTop($('.navbar-fixed-top').offset().top);
			}, 150);
		}

		$doc.on('touchmove', touchmoveEvent);
	});

	$navbarSearch.blur(function(event) {
		$('.navbar-fixed-top').removeClass('fix-fixed');
		$('.navbar-fixed-top').css('top', 'none');
		$doc.off('touchmove', touchmoveEvent);
	});

	/* Load Fastclick */
	$.ajax({
		url: Asset.rev('/js/fastclick.min.js'),
		dataType: 'script',
		cache: true
	}).done(function() {
		FastClick.attach(doc.body);

		/* Load jquery.touchSwipe */
		$.ajax({
			url: Asset.rev('/js/jquery.touchSwipe.min.js'),
			dataType: 'script',
			cache: true
		}).done(function() {
			$doc.trigger('swipe.load.after');
		});
	});

	/*var initSwipe = function() {
		$(document.body).swipe({
			swipeRight: function() {
				history.go(-1);
			},
			swipeLeft: function() {
				history.forward();
			}
		});
	};

	if (Modernizr.history) {
		if ($.fn.swipe) {
			initSwipe();			
		}
		else {
			$doc.on('swipe.load.after', function() {
				initSwipe();
			});
		}
	}*/
})(jQuery, document);
