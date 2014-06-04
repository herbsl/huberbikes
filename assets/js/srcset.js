(function($, win, doc) {
    if ('srcset' in doc.createElement('img'))
        return true;

    var maxWidth   = (win.innerWidth > 0) ? win.innerWidth : screen.width,
        maxHeight  = (win.innerHeight > 0) ? win.innerHeight : screen.height,
        maxDensity = win.devicePixelRatio || 1;

    function srcset(image) {
        if (! image.attributes['srcset']) {
			return false;
		}

        var candidates = image.attributes['srcset'].nodeValue.split(',');

        for (var i = 0; i < candidates.length; i++) {
            var descriptors = candidates[i].match(
                    /^\s*([^\s]+)\s*(\s(\d+)w)?\s*(\s(\d+)h)?\s*(\s(\d+)x)?\s*$/
                ),
                filename = descriptors[1],
                width    = descriptors[3] || false,
                height   = descriptors[5] || false,
                density  = descriptors[7] || 1;

            if (width && width > maxWidth || height && height > maxHeight ||
				density && density > maxDensity) {
                continue;
            }

            image.src = filename;
        }
    }

	$(doc).ready(function() {
		$('img').each(function() {
			srcset(this);
		});
	});

	$(doc).on('singlepage.load.inject', function(event, $content) {
	    $content.find('img').each(function() {
			srcset(this);
		});
	});
})(jQuery, window, document);
