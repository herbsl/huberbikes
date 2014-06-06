(function($, doc) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navs = $('#navbar-main, #navbar-secondary, .navbar-brand'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown'),
		$close = $('#js-navbar-close'),
		$meta = $('meta[name="viewport"]'),
		elStore = {},
		$lastEl,
		$doc = $(document);

	var setActive = function($el) {
		$navs.find('li.active').removeClass('active');

		if ($el === undefined) {
			return;
		}

		$el.closest('li').addClass('active')
			.closest('.dropdown').addClass('active');
	};

	/* Disable links because we have javascript */
	$('.dropdown-toggle, #responsive-menu').attr('href', '#');

	/* Fix input field on iphone */
	$search.on('touchstart', function(event) {
		var content = $meta.attr('content');
		content = content.replace(/user-scalable=yes/, 'user-scalable=no');
		$meta.attr('content', content);
	});

	$search.blur(function(event) {
		var content = $meta.attr('content');
		content = content.replace(/user-scalable=no/, 'user-scalable=yes');
		$meta.attr('content', content);
	});

	$doc.on('singlepage.load.before', function(event, params) {
		var $el;

		if (document.activeElement) {
			document.activeElement.blur();
		}

		if (params.$el) {
			if (params.$el.closest($navs).length > 0) {
				// Navbar click
				$el = params.$el;
				$lastEl = $el;
				setActive($el);
			}
			else {
				$el = $lastEl;
			}

			elStore[params.uid] = $el;
		}
		else {
			$el = elStore[params.uid];
			setActive($el);
		}

		/* Close main-navbar */
		if ($navbarMain.hasClass('in')) {
			$navbarMain.removeClass('in');
		}

		/* Manipulate search-field */
		if (! params.query.match(/q=/) && ! params.url.match(/q=/)) {
			$search.typeahead('val', '');
			$search.val('');
		}

		$search.typeahead('close');
		$search.blur();

		/* Close Dropdown */
		$dropdown.each(function() {
			var $this = $(this);

			if ($this.hasClass('open')) {
				$this.find('.dropdown-toggle').dropdown('toggle');
			}
		});

		if (params.url.match(/bike\/[0-9]*$/)) {
			$close.attr('href', window.location);
			$close.removeClass('invisible');
		}
		else {
			$close.attr('href', '#');
			$close.addClass('invisible');
		}
	});

	$doc.on('singlepage.load.after', function(event, params) {
		/* Maniuplate link to start-page */
		if (params.url === '/') {
			$navbarBrand.attr('href', '#');
		}
		else {
			$navbarBrand.attr('href', '/');
		}
	});
})(jQuery, document);
