(function($, win) {
	'use strict';

	var $win = $(win),
		$title = $('title'),
		$content = $('#singlepage-content'),
		$dropdown = $('#navbar-main .dropdown'),
		$navbarMain = $('#navbar-main'),
		$search = $('#navbar-search'),
		$navbarBrand = $('a.navbar-brand'),
		$navbarSecondary = $('#navbar-secondary');

	var loadContent = function(url, add) {
		var $js = $('#singlepage-javascript'),
			slide = add;

		if (url === '/') {
			slide = false;
		}

		/* Clear search-value */
		if (url.substr(0, 12) !== '/bikes/suche') {
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

		/* Close Dropdown and Navbar */
		if ($dropdown.hasClass('open')) {
			$dropdown.find('.dropdown-toggle').dropdown('toggle');
		}	
		if ($navbarMain.hasClass('in')) {
			$navbarMain.collapse('hide');
		}

		win.setTimeout(function() {
			$.get(url, function(data) {
				/* Manipulate active state of Navbar */
				$navbarMain.find('li.active').removeClass('active');
				var $a = $navbarMain.find('li a[href="' + url + '"]');
				$a.parent().addClass('active');
				$a.closest('li.dropdown').addClass('active');
				
				$navbarSecondary.find('li.active').removeClass('active');
				$a = $navbarSecondary.find('li a[href="' + url + '"]');
				$a.parent().addClass('active');

				if (url === '/') {
					$navbarBrand.attr('href', '#');
				}
				else {
					$navbarBrand.attr('href', '/');
				}

				/* Inject new Page */
				//$content.empty();
				$content.children().each(function() {
					var $this = $(this);

					if ($this.attr('id') !== 'navbar-secondary') {
						$this.remove();
					}
				});
				$('html, body').scrollTop(0);

				$title.text($(data).filter('title').text());
				$content.prepend($(data).filter('#singlepage-content').children());
				$js.html($(data).filter('#singlepage-javascript'));
		
				if (slide) {
					$content.removeClass('slideout-left-go');
					$content.addClass('slidein-right-go');
				}

				if (add) {
					if (! Modernizr.history) {
						console.log('push History');
						History.pushState({}, '', url);
					}
					else {
						console.log('push history');
						history.pushState({}, '', url);
					}
				}
			});
		}, 0);

		return false;
	};

	if (! Modernizr.history) {
		$(win).on('statechange', function(event) {
			var state = History.getState();
			console.log(state);
			return loadContent(state.hash, false);
		});
	} else {
		$(win).on('popstate', function(event) {
			if (event.originalEvent.state === null) {
				return;
			}
			console.log('pop history');

			return loadContent(location.href, false);
		});
	}

	$('body, .navbar-brand').click(function(event) {
		var $target = $(event.target),
			$el = $target.closest('a, form');

		if ($el.length === 0 || $target.prop('tagName').toLowerCase() === 'input') {
			return;
		}
			
		var url, tag = $el.prop('tagName').toLowerCase();
			
		if (tag === 'a') {
			url = $el.attr('href');
		}
		else if (tag === 'form') {
			url = $el.attr('action') + '?' + $el.serialize();
		}

		if (! url || url === '/responsive-menu' || url.charAt(0) != '/' || $el.data('toggle') === 'modal') {
			return true;
		}

		return loadContent(url, true);
	});
})(jQuery, window);
