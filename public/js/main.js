/* Modernizr 2.8.0 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-history-touch-teststyles-prefixes
 */
;



window.Modernizr = (function( window, document, undefined ) {

    var version = '2.8.0',

    Modernizr = {},


    docElement = document.documentElement,

    mod = 'modernizr',
    modElem = document.createElement(mod),
    mStyle = modElem.style,

    inputElem  ,


    toString = {}.toString,

    prefixes = ' -webkit- -moz- -o- -ms- '.split(' '),



    tests = {},
    inputs = {},
    attrs = {},

    classes = [],

    slice = classes.slice,

    featureName, 


    injectElementWithStyles = function( rule, callback, nodes, testnames ) {

      var style, ret, node, docOverflow,
          div = document.createElement('div'),
                body = document.body,
                fakeBody = body || document.createElement('body');

      if ( parseInt(nodes, 10) ) {
                      while ( nodes-- ) {
              node = document.createElement('div');
              node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
              div.appendChild(node);
          }
      }

                style = ['&#173;','<style id="s', mod, '">', rule, '</style>'].join('');
      div.id = mod;
          (body ? div : fakeBody).innerHTML += style;
      fakeBody.appendChild(div);
      if ( !body ) {
                fakeBody.style.background = '';
                fakeBody.style.overflow = 'hidden';
          docOverflow = docElement.style.overflow;
          docElement.style.overflow = 'hidden';
          docElement.appendChild(fakeBody);
      }

      ret = callback(div, rule);
        if ( !body ) {
          fakeBody.parentNode.removeChild(fakeBody);
          docElement.style.overflow = docOverflow;
      } else {
          div.parentNode.removeChild(div);
      }

      return !!ret;

    },
    _hasOwnProperty = ({}).hasOwnProperty, hasOwnProp;

    if ( !is(_hasOwnProperty, 'undefined') && !is(_hasOwnProperty.call, 'undefined') ) {
      hasOwnProp = function (object, property) {
        return _hasOwnProperty.call(object, property);
      };
    }
    else {
      hasOwnProp = function (object, property) { 
        return ((property in object) && is(object.constructor.prototype[property], 'undefined'));
      };
    }


    if (!Function.prototype.bind) {
      Function.prototype.bind = function bind(that) {

        var target = this;

        if (typeof target != "function") {
            throw new TypeError();
        }

        var args = slice.call(arguments, 1),
            bound = function () {

            if (this instanceof bound) {

              var F = function(){};
              F.prototype = target.prototype;
              var self = new F();

              var result = target.apply(
                  self,
                  args.concat(slice.call(arguments))
              );
              if (Object(result) === result) {
                  return result;
              }
              return self;

            } else {

              return target.apply(
                  that,
                  args.concat(slice.call(arguments))
              );

            }

        };

        return bound;
      };
    }

    function setCss( str ) {
        mStyle.cssText = str;
    }

    function setCssAll( str1, str2 ) {
        return setCss(prefixes.join(str1 + ';') + ( str2 || '' ));
    }

    function is( obj, type ) {
        return typeof obj === type;
    }

    function contains( str, substr ) {
        return !!~('' + str).indexOf(substr);
    }


    function testDOMProps( props, obj, elem ) {
        for ( var i in props ) {
            var item = obj[props[i]];
            if ( item !== undefined) {

                            if (elem === false) return props[i];

                            if (is(item, 'function')){
                                return item.bind(elem || obj);
                }

                            return item;
            }
        }
        return false;
    }
    tests['touch'] = function() {
        var bool;

        if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
          bool = true;
        } else {
          injectElementWithStyles(['@media (',prefixes.join('touch-enabled),('),mod,')','{#modernizr{top:9px;position:absolute}}'].join(''), function( node ) {
            bool = node.offsetTop === 9;
          });
        }

        return bool;
    };
    tests['history'] = function() {
      return !!(window.history && history.pushState);
    };
    for ( var feature in tests ) {
        if ( hasOwnProp(tests, feature) ) {
                                    featureName  = feature.toLowerCase();
            Modernizr[featureName] = tests[feature]();

            classes.push((Modernizr[featureName] ? '' : 'no-') + featureName);
        }
    }



     Modernizr.addTest = function ( feature, test ) {
       if ( typeof feature == 'object' ) {
         for ( var key in feature ) {
           if ( hasOwnProp( feature, key ) ) {
             Modernizr.addTest( key, feature[ key ] );
           }
         }
       } else {

         feature = feature.toLowerCase();

         if ( Modernizr[feature] !== undefined ) {
                                              return Modernizr;
         }

         test = typeof test == 'function' ? test() : test;

         if (typeof enableClasses !== "undefined" && enableClasses) {
           docElement.className += ' ' + (test ? '' : 'no-') + feature;
         }
         Modernizr[feature] = test;

       }

       return Modernizr; 
     };


    setCss('');
    modElem = inputElem = null;


    Modernizr._version      = version;

    Modernizr._prefixes     = prefixes;

    Modernizr.testStyles    = injectElementWithStyles;
    return Modernizr;

})(this, this.document);
;

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

(function($, win, undefined) {
	'use strict';

	if (! Modernizr.history) {
		return;
	}

	var $doc = $(document),
		$body = $('body'),
		$title = $('title'),
		$content = $('#singlepage-content'),
		uid = 0;

	var loadContent = function(params) {
		$doc.trigger('singlepage.load.before', params);

		$content.removeClass('slidein-right');
		$content.removeClass('slidein-right-go');
		$content.addClass('slideout-left-go');
		$content.addClass('slidein-right');

		$.ajax({
			url: params.url,
			data: params.query,
			type: params.type
		}).then(function(data, textStatus, xhrReq) {
			var location = xhrReq.getResponseHeader('X-Location');

			if (location) {
				params.addHistory = true;
				params.url = location;
			}

			/* Inject new Page */
			$content.children().each(function() {
				var $this = $(this);

				if ($this.attr('id') !== 'navbar-secondary') {
					$this.remove();
				}
			});

			$('html, body').scrollTop(0);

			$title.text($(data).filter('title').text());
			var $newContent = $(data).filter('#singlepage-content').children();

			$.when(
				$doc.trigger('singlepage.load.inject', [$newContent])
			).done(function() {
				$content.prepend($newContent);
				$('#singlepage-javascript').remove();
				$body.append($(data).filter('#singlepage-javascript'));
		
				$content.removeClass('slideout-left-go');
				$content.addClass('slidein-right-go');

				if (params.addHistory) {
					var $tmp = params.$el;
					params.$el = undefined;
					history.pushState(
						params, '', params.url);
					params.$el = $tmp;
				}

				$doc.trigger('singlepage.load.after', params);
			});
		});

		return false;
	};

	$(win).on('popstate', function(event) {
		var params;

		if (event.originalEvent.state === null) {
			params = {
				url: '/',
				query: '',
				reqType: 'get',
				uid: uid++
			};
		} else {
			params = event.originalEvent.state;
		}

		params.addHistory = false;

		return loadContent(params);
	});

	$('body, .navbar-brand').click(function(event) {
		var url, tag,
			query = '',
			reqType = 'get',
			$target = $(event.target),
			$el = $target.closest('a, button[type="submit"]');

		if ($el.length === 0) {
			return true;
		}

		if ($el.data('singlepage-load') === 'disabled' ) {
			if ($el.data('singlepage-prevent')) {
				event.preventDefault();
			}

			return true;
		}
			
		tag = $el.prop('tagName').toLowerCase();
			
		if (tag === 'a') {
			url = $el.attr('href');
		}
		else if (tag === 'button') {
			var $form = $el.closest('form');

			if ($form.attr('method') !== undefined) {
				type = $form.attr('method');
			}

			query = $form.serialize();
			url = $form.attr('action');
		}
		
		if (url  === undefined || url.charAt(0) === '#') {
			return true;
		}

		return loadContent({
			url: url,
			query: query,
			reqType: reqType,
			addHistory: (reqType === 'get') ? true : false,
			uid: uid++,
			$el: $el
		});
	});	
})(jQuery, window);

(function($, doc) {
	'use strict';

	var $navbarMain = $('#navbar-main'),
		$navbarBrand = $('a.navbar-brand'),
		$navs = $('#navbar-main, #navbar-secondary, .navbar-brand'),
		$search = $('#navbar-search'),
		$dropdown = $('#navbar-main .dropdown'),
		$close = $('#js-navbar-close'),
		$meta = $('meta[name="viewport"]'),
		elStore = {},
		$lastEl,
		$doc = $(document);

	var setActive = function($el) {
		$navs.find('li.active').removeClass('active');

		if ($el === undefined) {
			return;
		}

		$el.closest('li').addClass('active')
			.closest('.dropdown').addClass('active');
	};

	/* Disable links because we have javascript */
	$('.dropdown-toggle, #responsive-menu').attr('href', '#');

	/* Fix input field on iphone */
	$search.on('touchstart', function(event) {
		var content = $meta.attr('content');
		content = content.replace(/user-scalable=yes/, 'user-scalable=no');
		$meta.attr('content', content);
	});

	$search.blur(function(event) {
		var content = $meta.attr('content');
		content = content.replace(/user-scalable=no/, 'user-scalable=yes');
		$meta.attr('content', content);
	});

	$doc.on('singlepage.load.before', function(event, params) {
		var $el;

		if (document.activeElement) {
			document.activeElement.blur();
		}

		if (params.$el) {
			if (params.$el.closest($navs).length > 0) {
				// Navbar click
				$el = params.$el;
				$lastEl = $el;
				setActive($el);
			}
			else {
				$el = $lastEl;
			}

			elStore[params.uid] = $el;
		}
		else {
			$el = elStore[params.uid];
			setActive($el);
		}

		/* Close main-navbar */
		if ($navbarMain.hasClass('in')) {
			$navbarMain.removeClass('in');
		}

		/* Manipulate search-field */
		if (! params.query.match(/q=/) && ! params.url.match(/q=/)) {
			$search.typeahead('val', '');
			$search.val('');
		}

		$search.typeahead('close');
		$search.blur();

		/* Close Dropdown */
		$dropdown.each(function() {
			var $this = $(this);

			if ($this.hasClass('open')) {
				$this.find('.dropdown-toggle').dropdown('toggle');
			}
		});

		if (params.url.match(/bike\/[0-9]*$/)) {
			$close.attr('href', window.location);
			$close.removeClass('invisible');
		}
		else {
			$close.attr('href', '#');
			$close.addClass('invisible');
		}
	});

	$doc.on('singlepage.load.after', function(event, params) {
		/* Maniuplate link to start-page */
		if (params.url === '/') {
			$navbarBrand.attr('href', '#');
		}
		else {
			$navbarBrand.attr('href', '/');
		}
	});
})(jQuery, document);

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

	$(win).on('load', function() {
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

(function($, doc) {
	'use strict';
	
	if (! Modernizr.touch) {
		return;
	}

	var $doc = $(doc),
		$navbarSearch = $('#navbar-search');

	$('html').addClass('touch');
	
	/* Fix fixed scrollbar in Webkit */
	var touchmoveEvent = function(event) {
		$target = $(event.target);

		if ($target.closest('.navbar-form').length === 0) { 
			$navbarSearch.blur();
		}
	};

	$navbarSearch.focus(function(event) {
		if ($doc.scrollTop() !== 0) {
			$('.navbar-fixed-top').addClass('fix-fixed');
			$('.navbar-fixed-top').css('top', $doc.scrollTop());

			window.setTimeout(function() {
				$('html, body').scrollTop($('.navbar-fixed-top').offset().top);
			}, 150);
		}

		$doc.on('touchmove', touchmoveEvent);
	});

	$navbarSearch.blur(function(event) {
		$('.navbar-fixed-top').removeClass('fix-fixed');
		$('.navbar-fixed-top').css('top', 'none');
		$doc.off('touchmove', touchmoveEvent);
	});

	/* Load Fastclick */
	$.ajax({
		url: Asset.rev('/js/fastclick.min.js'),
		dataType: 'script',
		cache: true
	}).done(function() {
		FastClick.attach(doc.body);

		/* Load jquery.touchSwipe */
		$.ajax({
			url: Asset.rev('/js/jquery.touchSwipe.min.js'),
			dataType: 'script',
			cache: true
		}).done(function() {
			$doc.trigger('swipe.load.after');
		});
	});

	/*var initSwipe = function() {
		$(document.body).swipe({
			swipeRight: function() {
				history.go(-1);
			},
			swipeLeft: function() {
				history.forward();
			}
		});
	};

	if (Modernizr.history) {
		if ($.fn.swipe) {
			initSwipe();			
		}
		else {
			$doc.on('swipe.load.after', function() {
				initSwipe();
			});
		}
	}*/
})(jQuery, document);

(function($, win) {
	'use strict';

	$(win).on('load', function() {
		var css = Asset.rev('/css/typeahead.min.css'),
			js = Asset.rev('/js/typeahead.bundle.min.js');

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
					/*ttl: 0,*/
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
	});
})(jQuery, window);
