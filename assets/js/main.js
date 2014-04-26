(function($) {
	'use strict';

	var $title = $('title'),
		$content = $('#singlepage-content'),
		$style = $('#singlepage-style'),
		$js = $('#singlepage-javascript'),
		$dropdown = $('#navbar-main .dropdown'),
		$navbarMain = $('#navbar-main'),
		$search = $('#navbar-search'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarAdd = $('#navbar-add');

	if (! Modernizr.history) {
		return;
	}

	var loadContent = function(link, add) {
		var slide = add;

		if (link === '/') {
			slide = false;
			$navbarAdd.removeClass('hidden');
		}
		else if (link === '/so-finden-sie-uns' || link === '/impressum') {
			$navbarAdd.removeClass('hidden');
		}
		else {
			$navbarAdd.addClass('hidden');
		}

		// Clear search-value
		if (link.substr(0, 12) !== '/bikes/suche') {
			$search.typeahead('val', '');
			$search.val('');
		}
		$search.typeahead('close');
		$search.blur();


		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');

		if (slide) {
			$content.addClass('slidein-right');
		}

		// Close Dropdown and Navbar
		if ($dropdown.hasClass('open')) {
			$dropdown.find('.dropdown-toggle').dropdown('toggle');
		}	
		if ($navbarMain.hasClass('in')) {
			$navbarMain.collapse('hide');
		}

		window.setTimeout(function() {
			$.get(link, function(data) {
				// Manipulate active state of Navbar
				$navbarMain.find('li.active').removeClass('active');
				var $a = $navbarMain.find('li a[href="' + link + '"]');
				$a.parent().addClass('active');
				$a.closest('li.dropdown').addClass('active');
				
				$navbarAdd.find('li.active').removeClass('active');
				$a = $navbarAdd.find('li a[href="' + link + '"]');
				$a.parent().addClass('active');

				if (link === '/') {
					$navbarBrand.attr('href', '#');
				}
				else {
					$navbarBrand.attr('href', '/');
				}

				// Inject new Page
				$content.empty();
				$('html, body').scrollTop(0);

				$title.text($(data).filter('title').text());
				$style.html($(data).filter('#singlepage-style'));
			
				$content.html($(data).filter('#singlepage-content').children());
				$js.html($(data).filter('#singlepage-javascript'));
		
				if (slide) {
					$content.removeClass('slideout-left-go');
					$content.addClass('slidein-right-go');
				}

				if (add) {
					history.pushState({}, '', link);
				}
			});
		}, 0);
	};

	$(window).on('popstate', function(event) {
		if (event.originalEvent.state === null) {
			return;
		}
	    var a = document.createElement('a');
    	a.href = location.href + location.search;

		loadContent(a.pathname, false);
	});

	$('body, .navbar-brand').click(function(event) {
		var $target = $(event.target),
			$el = $target.closest('a, form');

		if ($el.length === 0 || $target.prop('tagName').toLowerCase() === 'input') {
			return;
		}
			
		var link, tag = $el.prop('tagName').toLowerCase();
			
		if (tag === 'a') {
			link = $el.attr('href');
		}
		else if (tag === 'form') {
			link = $el.attr('action') + '?' + $el.serialize();
		}

		if (! link || link === '/responsive-menu' || link.charAt(0) != '/' || $el.data('toggle') === 'modal') {
			return true;
		}

		loadContent(link, true);
		return false;
	});
})(jQuery);
