(function($) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarSecondary = $('#navbar-secondary'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown'),
		$close = $('#js-navbar-close'),
		$meta = $('meta[name="viewport"]');

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

	$(document).on('singlepage.load.before', function(event, url, data) {
		/* Close main-navbar */
		if ($navbarMain.hasClass('in')) {
			$navbarMain.removeClass('in');
		}

		/* Manipulate search-field */
		if (! data.match(/q=/) && ! url.match(/q=/)) {
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

		if (url.match(/bike\/[0-9]*$/)) {
			$close.attr('href', window.location);
			$close.removeClass('invisible');
		}
		else {
			$close.attr('href', '#');
			$close.addClass('invisible');
		}
	});

	$(document).on('singlepage.load.after', function(event, url) {
		/* Manipulate active-state of main-navbar */
		$navbarMain.find('li.active')
			.removeClass('active');

		$navbarMain.find('li a[href="' + url + '"]')
			.parent().addClass('active')
			.closest('li.dropdown').addClass('active');
				
		/* Manipulate active-state of secondary-navbar */
		$navbarSecondary.find('li.active')
			.removeClass('active');

		$navbarSecondary.find('li a[href="' + url + '"]')
			.parent().addClass('active');

		/* Maniuplate link to start-page */
		if (url === '/') {
			$navbarBrand.attr('href', '#');
		}
		else {
			$navbarBrand.attr('href', '/');
		}
	});
})(jQuery);
