(function($) {
	'use strict';

	var height,
		$win = $(window),
		$root = $('html, body'),
		$scrollTop = $('.scroll-top'),
		visible = true;

	$win.resize(function() {
		height = $win.height();
	}).trigger('resize');

	$win.scroll(function() {
		if ($win.scrollTop() > height / 2) {
			if (! visible) {
				visible = true;
				$scrollTop.fadeIn(250);
			}
		}
		else {
			if (visible) {
				visible = false;
				$scrollTop.fadeOut(250);
			}
		}
	}).trigger('scroll');

	$scrollTop.click(function() {
		var scrollTime = Math.min($win.scrollTop() / 2, 750);

		$root.animate({
			scrollTop: 0
		}, scrollTime);

		return false;
	});
})(jQuery);
