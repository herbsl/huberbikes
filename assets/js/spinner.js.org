(function($, doc) {
	var spinner,
		target = document.getElementById('spinner'),
		opts = {
			lines: 13,
			length: 7,
			width: 2,
			radius:  9 
		};

	var stop = function() {
		if (spinner) {
			spinner.stop();
			spinner = undefined;
		}
	};

	$(doc).on('singlepage.load.before', function(event, params) {
		stop();
		spinner = new Spinner(opts).spin(target);
	});

	$(doc).on('singlepage.load.after', function(event, params) {
		$(spinner.el).fadeOut(250, function() {
			stop();
		});
	});
})(jQuery, document);
