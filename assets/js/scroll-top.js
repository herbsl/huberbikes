(function($) {
	'use strict';

	var height,
		$win = $(window),
		$root = $('html, body'),
		$scrollTop = $('#scroll-top'),
		visible = true;

	$win.resize(function() {
		height = $win.height();
	}).trigger('resize');

	$win.scroll(function() {
		if ($win.scrollTop() > height / 2) {
			if (! visible) {
				visible = true;
				$scrollTop.removeClass('hidden');
				$scrollTop.addClass('show');
			}
		}
		else {
			if (visible) {
				visible = false;
				$scrollTop.removeClass('show');
				$scrollTop.addClass('hidden');
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
