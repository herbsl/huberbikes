(function($, doc, undefined) {
	'use strict';

	var $doc = $(doc);

    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,doc,'script','ga'));

	if (ga === undefined) {
		return;
	}

    ga('create','UA-51739955-1', {
		'cookieDomain': 'huberbikes.de'
	});
	ga('send','pageview');       

	$doc.on('singlepage.load.after', function(event, params) {
		var parser = doc.createElement('a'),
		url = params.url;

		if (params.query !== undefined && params.query !== '') {
			url = url + '?' + params.query;
		}

		parser.href = url;
		ga('send', 'pageview', parser.pathname + parser.search);
	});	
})(jQuery, document);
