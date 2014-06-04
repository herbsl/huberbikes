(function($, win, undefined) {
	'use strict';

	if (! Modernizr.history) {
		return;
	}

	var $doc = $(document),
		$body = $('body'),
		$title = $('title'),
		$content = $('#singlepage-content'),
		elStore = {},
		count = 0;

	var loadContent = function(params) {
		$doc.trigger('singlepage.load.before', params);
			
		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');
		$content.addClass('slidein-right');

		$.ajax({
			url: params.url,
			data: params.query,
			type: params.type
		}).then(function(data, textStatus, xhrReq) {
			var location = xhrReq.getResponseHeader('X-Location');

			if (location) {
				params.addHistory = true;
				params.url = location;
			}

			/* Inject new Page */
			$content.children().each(function() {
				var $this = $(this);

				if ($this.attr('id') !== 'navbar-secondary') {
					$this.remove();
				}
			});

			$('html, body').scrollTop(0);

			$title.text($(data).filter('title').text());
			var $newContent = $(data).filter('#singlepage-content').children();

			$.when(
				$doc.trigger('singlepage.load.inject', [$newContent])
			).done(function() {
				$content.prepend($newContent);
				$('#singlepage-javascript').remove();
				$body.append($(data).filter('#singlepage-javascript'));
		
				$content.removeClass('slideout-left-go');
				$content.addClass('slidein-right-go');

				if (params.addHistory) {
					params.$el = undefined;
					history.pushState(
						params, '', params.url);
					params.$el = elStore[params.id];
				}

				$doc.trigger('singlepage.load.after', params);
			});
		});

		return false;
	};

	$(win).on('popstate', function(event) {
		if (event.originalEvent.state === null) {
			return;
		}

		var params = event.originalEvent.state;
		params.addHistory = false;
		params.$el = elStore[params.id];

		return loadContent(params);
	});

	$('body, .navbar-brand').click(function(event) {
		var url, tag,
			query = '',
			reqType = 'get',
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

			query = $form.serialize();
			url = $form.attr('action');
		}

		if (! url || url.charAt(0) === '#') {
			return true;
		}

		var id = $el.data('singlepage-id');
		if (id === undefined) {
			id = count++;
			$el.data('singlepage-id', id);
			elStore[id] = $el;
		}

		return loadContent({
			url: url,
			query: query,
			reqType: reqType,
			addHistory: (reqType === 'get') ? true : false,
			id: id,
			$el: $el
		});
	});	
})(jQuery, window);
