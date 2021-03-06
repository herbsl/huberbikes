(function($, win, undefined) {
	'use strict';

	if (! Modernizr.history) {
		return;
	}

	var $doc = $(document),
		$body = $('body'),
		$title = $('title'),
		$content = $('#singlepage-content'),
		uid = 0;

	var loadContent = function(params) {
		$doc.trigger('singlepage.load.before', params);

		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');
		$content.addClass('slidein-right');
		
		$.ajax({
			url: params.url,
			data: params.query,
			type: params.type,
			beforeSend: function(xhr, opts) {
				if (this.url.indexOf('?') === -1) {
					this.url += '?ajax=true';
				}
				else {
					this.url += '&ajax=true';
				}
			}
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
					var $tmp = params.$el;
					params.$el = undefined;

					var url = params.url;
					if (params.query !== undefined && params.query !== '') {
						if (url.indexOf('?') === -1) {
							url += '?' + params.query;
						}
						else {
							url += '&' + params.query;
						}
					}

					history.pushState(
						params, '', url);
					params.$el = $tmp;
				}

				$doc.trigger('singlepage.load.after', params);
			});
		});

		return false;
	};

	$(win).on('popstate', function(event) {
		var params;

		if (event.originalEvent.state === null) {
			params = {
				url: '/',
				query: '',
				reqType: 'get',
				uid: uid++
			};
		} else {
			params = event.originalEvent.state;
		}

		params.addHistory = false;

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

		if ($el.data('singlepage-load') === 'disabled' || $el.attr("target") === "_blank") {
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
		
		if (url  === undefined || url.charAt(0) === '#') {
			return true;
		}

		return loadContent({
			url: url,
			query: query,
			reqType: reqType,
			addHistory: (reqType === 'get') ? true : false,
			uid: uid++,
			$el: $el
		});
	});	
})(jQuery, window);
