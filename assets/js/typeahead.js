(function($) {
	'use strict';

    if (document.createStyleSheet){
		document.createStyleSheet('/css/typeahead.min.css');
    }
    else {
    	$("head").append($("<link rel='stylesheet' type='text/css' href='/css/typeahead.min.css'>"));
	}

	$.ajax({
		url: '/js/typeahead.bundle.min.js',
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
})(jQuery);
