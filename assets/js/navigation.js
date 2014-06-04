(function($, doc) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarSecondary = $('#navbar-secondary'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown'),
		$close = $('#js-navbar-close'),
		$meta = $('meta[name="viewport"]');

	var removeActive = function($nav) {
		$nav.find('li.active')
			.removeClass('active');
	};

	var setActive = function($el) {
		if (! $el || $el.closest('.navbar').length === 0) {
			return;
		}

		removeActive($navbarMain);
		removeActive($navbarSecondary);

		$el.parent().addClass('active')
			.closest('li.dropdown').addClass('active');
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

	$(doc).on('singlepage.load.before', function(event, params) {
		setActive(params.$el);

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

	$(doc).on('singlepage.load.after', function(event, params) {
		/* Maniuplate link to start-page */
		if (params.url === '/') {
			$navbarBrand.attr('href', '#');
		}
		else {
			$navbarBrand.attr('href', '/');
		}
	});
})(jQuery, document);
