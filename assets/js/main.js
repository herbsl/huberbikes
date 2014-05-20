(function($, win) {
	'use strict';

	var $doc = $(document),
		$body = $('body'),
		$title = $('title'),
		$content = $('#singlepage-content');

	var loadContent = function(url, data, type, add) {
		var slide = add;

		if (url === '/') {
			slide = false;
		}

		if (! Modernizr.history) {
			return;
		}

		$doc.trigger('singlepage.load.before', [ url ]);
			
		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');

		if (slide) {
			$content.addClass('slidein-right');
		}

		win.setTimeout(function() {
			$.ajax({
				url: url,
				data: data,
				type: type,
				success: function(data) {
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
				$('#singlepage-javascript').remove();
				$body.append($(data).filter('#singlepage-javascript'));
		
				if (slide) {
					$content.removeClass('slideout-left-go');
					$content.addClass('slidein-right-go');
				}

				if (add) {
					if (Modernizr.history) {
						history.pushState({}, '', url);
					} /*else {
						History.pushState({}, '', url);
					}*/
				}

				$doc.trigger('singlepage.load.after', [ url ]);
				}	
			});
		}, 0);

		return false;
	};

	if (Modernizr.history) {
		$(win).on('popstate', function(event) {
			if (event.originalEvent.state === null) {
				return;
			}

			return loadContent(location.href, '', 'get', false);
		});
	} /*else {
		$(win).on('statechange', function(event) {
			var state = History.getState();
			return loadContent(state.hash, '', 'get', false);
		});
	}*/

	$('body, .navbar-brand').click(function(event) {
		var url, tag,
			data = '',
			type = 'get',
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
			var $form = $el.closest('form');
			if ($form.attr('method') !== undefined) {
				type = $form.attr('method');
			}

			data = $form.serialize();
			url = $form.attr('action');
		}

		if (! url || url.charAt(0) === '#' /*|| (url.charAt(0) != '/' && url.charAt(0) != '?')*/) {
			return true;
		}

		return loadContent(url, data, type, (type === 'get') ? true : false);
	});
})(jQuery, window);
