(function($, doc) {
	var spinner,
		target = doc.getElementById('spinner'),
		opts = {
			lines: 13,
			length: 10,
			width: 3,
			radius: 10
		};

	$(doc).on('singlepage.load.before', function() {
		spinner = new Spinner(opts).spin(target);
	});

	$(doc).on('singlepage.load.after', function() {
		$(spinner.el).fadeOut(250, function() {
			spinner.stop();
		});
	});
})(jQuery, document);
