(function($) {
	'use strict';

	var css = '/css/addons/' + Asset.rev('typeahead.min.css'),
		js = '/js/addons/' + Asset.rev('typeahead.bundle.min.js');

    if (document.createStyleSheet){
		document.createStyleSheet(css);
    }
    else {
    	$("head").append($("<link rel='stylesheet' type='text/css' href='" + 
			css + "'>"));
	}

	$.ajax({
		url: js,
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
