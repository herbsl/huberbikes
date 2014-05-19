(function($) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarSecondary = $('#navbar-secondary'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown');

	$('#responsive-menu').click(function(event) {
		// The click should only be triggered without javascript
		event.preventDefault();
	});

	$('.dropdown-toggle').attr('href', '#');

	$(document).on('singlepage.load.before', function(event, url) {
		/* Close main-navbar */
		if ($navbarMain.hasClass('in')) {
			$navbarMain.removeClass('in');
		}

		/* Manipulate search-field */
		if (url.substr(0, 12) !== '/bikes/suche') {
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
			.removeClass('active')
			.find('li a[href="' + url + '"]')
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
