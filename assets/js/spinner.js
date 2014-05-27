(function($, doc) {
	var spinner,
		target = doc.getElementById('spinner'),
		opts = {
		lines: 13, // The number of lines to draw
		length: 10,
		width: 3,
		radius: 12
	};

	$(doc).on('singlepage.load.before', function() {
		spinner = new Spinner(opts).spin(target);
	});

	$(doc).on('singlepage.load.after', function() {
		spinner.stop();
	});
})(jQuery, document);
