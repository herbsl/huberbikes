!function(e){"use strict";var t=Asset.rev("/css/typeahead.min.css"),n=Asset.rev("/js/typeahead.bundle.min.js");document.createStyleSheet?document.createStyleSheet(t):e("head").append(e("<link rel='stylesheet' type='text/css' href='"+t+"'>")),e.ajax({url:n,dataType:"script",cache:!0}).done(function(){var t=new Bloodhound({datumTokenizer:function(e){return Bloodhound.tokenizers.whitespace(e.value)},queryTokenizer:Bloodhound.tokenizers.whitespace,limit:10,prefetch:{ttl:0,url:"/api/suggestions",filter:function(t){return e.map(t,function(e){return{value:e}})}}});t.initialize(),e("#navbar-search").typeahead({hint:!0},{source:t.ttAdapter()})})}(jQuery);