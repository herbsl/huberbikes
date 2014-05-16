(function($, win) {
	'use strict';

	var $doc = $(document),
		$title = $('title'),
		$content = $('#singlepage-content');

	if (! Modernizr.history) {
		return;
	}

	var loadContent = function(url, add) {
		var $js = $('#singlepage-javascript'),
			slide = add;

		if (url === '/') {
			slide = false;
		}

		$doc.trigger('singlepage.load.before', [ url ]);
			
		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');

		if (slide) {
			$content.addClass('slidein-right');
		}

		win.setTimeout(function() {
			$.get(url, function(data) {
				/* Inject new Page */
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
						History.pushState({}, '', url);
					}
					else {
						history.pushState({}, '', url);
					}
				}

				$doc.trigger('singlepage.load.after', [ url ]);
			});
		}, 0);

		return false;
	};

	if (! Modernizr.history) {
		$(win).on('statechange', function(event) {
			var state = History.getState();
			return loadContent(state.hash, false);
		});
	} else {
		$(win).on('popstate', function(event) {
			if (event.originalEvent.state === null) {
				return;
			}

			return loadContent(location.href, false);
		});
	}

	$('body, .navbar-brand').click(function(event) {
		var url, tag,
			$target = $(event.target),
			$el = $target.closest('a, button[type="submit"]');

		if ($el.length === 0) {
			return true;
		}

		if ($el.data('singlepage-load') === 'disabled' ) {
			if ($el.data('singlepage-prevent')) {
				event.preventDefault();
			}

			return true;
		}
			
		tag = $el.prop('tagName').toLowerCase();
			
		if (tag === 'a') {
			url = $el.attr('href');
		}
		else if (tag === 'button') {
			url = $el.closest('form').attr('action') + '?' + $el.serialize();
		}

		if (! url || (url.charAt(0) != '/' && url.charAt(0) != '?')) {
			return true;
		}

		return loadContent(url, true);
	});
})(jQuery, window);
