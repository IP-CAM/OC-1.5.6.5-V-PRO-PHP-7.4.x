/**
 * @author shahroq[at]yahoo[dot]com
 * @version 1.0
 *
 * @name traverseMenu
 * @type jQuery
 */

(function( $ ){
	jQuery.fn.traverseMenu = function () {
		var menu = [];
		var elems;
		var indent = '-';


		li0 = this.children(); //level 0
		if( li0.length > 0) {
		li0.each(function(index, value) {
			depth = 0;
			//console.log(depth);

			title = Array(depth + 1).join(indent) + " " + $(this).find('a').html();
			url = $(this).find('a').attr('href');

			path = '';
			if(typeof url != "undefined") path = queryString(url,'route');
			menu.push([title,path]);

			//level 1
			li1 = $(this).find('ul:first > li');
			if( li1.length > 0) {
			li1.each(function(index, value) {
				depth = 1;
				title = Array(depth + 1).join(indent) + " " + $(this).find('a').html();
				url = $(this).find('a').attr('href');
				path = '';
				if(typeof url != "undefined") path = queryString(url,'route');
				menu.push([title,path]);

				//level 2
				li2 = $(this).find('ul:first > li');
				if( li2.length > 0) {
				depth = 2;
				li2.each(function(index, value) {
					title = Array(depth + 1).join(indent) + " " + $(this).find('a').html();
					url = $(this).find('a').attr('href');
					path = '';
					if(typeof url != "undefined") path = queryString(url,'route');
					menu.push([title,path]);
				});
				}


			});
			}

		});
		}
		//console.log(elems);
		return menu;

	};

})( jQuery );

function queryString(url,name) {
	var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
        query  = url.substring(url.indexOf("?")+1);

    urlParams = {};
    while (match = search.exec(query)){
        //urlParams[decode(match[1])] = decode(match[2]);
        if(name==decode(match[1])) {
			return decode(match[2]);
	    }
    }
    return false;
}