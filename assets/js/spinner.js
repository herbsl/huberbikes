(function($, doc) {
	var spinner,
		target = document.getElementById('spinner'),
		opts = {
			lines: 13,
			length: 7,
			width: 2,
			radius:  7 
		};

	var stop = function() {
		if (spinner) {
			spinner.stop();
			spinner = undefined;
		}
	};

	$(doc).on('singlepage.load.before', function() {
		stop();
		spinner = new Spinner(opts).spin(target);
	});

	$(doc).on('singlepage.load.after', function() {
		$(spinner.el).fadeOut(250, function() {
			stop();
		});
	});
})(jQuery, document);
