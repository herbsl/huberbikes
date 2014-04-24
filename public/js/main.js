(function() {
	$('#responsive-menu').click(function(event) {
		// The click should only be triggered without javascript
		event.preventDefault();
	});

	$('.dropdown-toggle').attr('href', '#');
})();

(function() {
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
})();

(function() {
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
		url: '/js/vendor/fastclick.min.js',
		dataType: 'script',
		cache: true
	}).done(function() {
		FastClick.attach(document.body);
	});
})();

(function() {
	// Load Typeahead
    if (document.createStyleSheet){
		document.createStyleSheet('/css/typeahead.min.css');
    }
    else {
    	$("head").append($("<link rel='stylesheet' type='text/css' href='/css/typeahead.min.css'>"));
	}

	$.ajax({
		url: '/js/vendor/typeahead.bundle.min.js',
		dataType: 'script',
		cache: true
	}).done(function() {
		var engine = new Bloodhound({	
			datumTokenizer: function(d) {
				return Bloodhound.tokenizers.whitespace(d.value);
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			prefetch: {
				ttl: 0,
				url: '/api/suggestions',
				filter: function(list) {
					return $.map(list, function(suggestion) {
						return { value: suggestion };
					});
				}
			}
		});

		engine.initialize();

		$('#navbar-search').typeahead({
			hint: true
		}, {
			source: engine.ttAdapter()
		});
	});
})();
