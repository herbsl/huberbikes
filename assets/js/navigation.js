(function($) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarSecondary = $('#navbar-secondary'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown'),
		$close = $('#js-navbar-close'),
		$meta = $('meta[name="viewport"]'),
		navStore = {};

	var removeActive = function($nav) {
		$nav.find('li.active')
			.removeClass('active');
	};

	$navbarMain.click(function(event) {
		var $target = $(event.target);

		if ($target.data('singlepage-load')) {
			return;
		}
		
		removeActive($navbarMain);
		removeActive($navbarSecondary);

		$target.parent().addClass('active')
			.closest('li.dropdown').addClass('active');
	});

	$navbarSecondary.click(function(event) {
		var $target = $(event.target);

		if ($target.data('singlepage-load')) {
			return;
		}

		removeActive($navbarMain);
		removeActive($navbarSecondary);

		$(event.target).parent().addClass('active');
	});

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

	$('#responsive-menu').click(function(event) {
		// The click should only be triggered without javascript
		event.preventDefault();
	});

	$('.dropdown-toggle').attr('href', '#');

	$(document).on('singlepage.load.before', function(event, params) {
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

	$(document).on('singlepage.load.after', function(event, params) {
		/* Maniuplate link to start-page */
		if (params.url === '/') {
			$navbarBrand.attr('href', '#');
		}
		else {
			$navbarBrand.attr('href', '/');
		}
	});
})(jQuery);
