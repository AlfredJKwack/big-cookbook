function calcFocus(cropSize, imgSize) {
	//converting a topLeft origin with box coordinate axis to a center based coordinate one.
	var focusPt = {
		x: ((cropSize.x + (cropSize.width/2))-(imgSize.w/2))/(imgSize.w/2),
		y: ((imgSize.h/2) - (cropSize.y + (cropSize.height/2)))/(imgSize.h/2)		
	};
	return focusPt;
}

//
// jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
//
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	}
});

jQuery(document).ready( function($) {	

	// Handlers for menu buttons
	var setLeftMenuEvents = function(selector){
		$(selector).click(function() {
			if ($('body').hasClass('is--pushed-left')){$('body').toggleClass('is--pushed-left')}
			$('body').toggleClass('is--pushed-right');
			$('article #abstract .trigger').toggleClass('is--hidden');
		});
	};
	var setRightMenuEvents = function(selector){
		$(selector).click(function() {
			$('.right-menu').toggleClass('trigger--active');
			if ($('body').hasClass('is--pushed-right')){$('body').toggleClass('is--pushed-right')};
			$('body').toggleClass('is--pushed-left');
		})
	};

	// Handler for the featured image eye candy
	var setFeaturedImgCandy = function(selector){

		if ( $(selector).length ) { //check is something was passed in.

			var $theImage = $(selector)[0]
	 
			// fire when image has loaded
			$('<img />').one('load', function() {


				// Set background of image to dominant image color
				// you actually want this to be server side...

				//var colorThief = new ColorThief();
				//var color = colorThief.getColor($theImage);
				//var rgbValue = 'rgb('+color.join()+')';
				//var rgbaValue = 'rgba('+color.join()+',0.2)';
				//$('div.featured-img').css('background-color', rgbValue);
				//$('#abstract').css('background-color', rgbaValue);
				
				
				//'this' references to the newly created <img />
				var imgData = {
					w: this.width,
					h: this.height			
				};

				// get an appropriate crop window
				var cropData = SmartCrop.crop(this, {
						width: 250,		// keeping this slightly smaller than min-height
						height: 250,
						minScale: 0.9
					}, function(result) {
						return result;
					}
				);
				
				// get and set a focus point
				var focusPoint = calcFocus(cropData.topCrop, imgData);
				$($theImage).parent().attr({
					"data-focus-x": focusPoint.x,
					"data-focus-y": focusPoint.y,
					"data-focus-w": imgData.w,
					"data-focus-h": imgData.h
				});
				$($theImage).parent().focusPoint();
				
				// set the text color based on the feature image background
				BackgroundCheck.init({
					minComplexity: 16,
					targets: '#abstract h1, #meta, #brand-link', //can't abstract this?
					images: $theImage
				});		
				
				// make the image appear
				$($theImage).removeClass('is--invisible').hide().fadeIn(1800, 'easeInOutQuad');	
				
			}).attr('src', $theImage.src);    	
	 
		} //if ( $(this).length )
	};	

	// Gets a given article and updates the page part
	var loadArticle = function(post_id){
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load_single_article", post_id: post_id},
            beforeSend: function() {
            	$('.main.wrapper > article > header .featured-img').remove();
            	$('.main.wrapper > article > header #meta').remove();
            	$('.main.wrapper > article #article_body section').remove();
            	$('.main.wrapper > article #article_body footer').remove();

            	$('.main.wrapper > article > header h1').text('Loading article');
            	$('.main.wrapper > article #article_body').prepend('Please hold while we load the content');
            },
            success: function(response){
            	$('.main.wrapper > article').remove();
            	$('.main.wrapper').prepend(response);

            	setLeftMenuEvents('.main.wrapper > article .left-menu');
            	setRightMenuEvents('#article_body .right-menu');
            	$('article #abstract .trigger').toggleClass('is--hidden');

            	setFeaturedImgCandy('div.featured-img.focuspoint img');
            	setTimeout(function() {
				    $('#blog-list .left-menu').trigger('click');
				}, 500);
            }
        });
	};

	window.addEventListener('popstate', function(e){
		console.log('popstate event: ');
		console.log(e.state);
		//console.log('popstate event: ' + e.state.post_id);

		if (e.state != null) {
			console.log(e.state['post']);
			loadArticle(e.state['post']);
			document.title = e.state['title'] + " | " + window.location.hostname;
		} 
	})

	// Set event handler to load articles
	$('a.ajax-load-article').click(function(e){

		if (event.metaKey || event.ctrlKey) {  // allow people to follow cmd/ctrl clicks
		    return true;

		} else { // it's a normal click

			e.preventDefault();

			var post_id = $(this).attr('id').slice(5);
			var post_title = $(this).find('h1').first().text();
			var defaultTitle = document.title;

			// set browser history
			history.pushState( 
				{
					title: post_title,
					post: post_id
				}, 
				null, 
				$(this).attr('href')
			);

			loadArticle(post_id);
			document.title = document.title = post_title + " | " + window.location.hostname;;

			e.stopPropagation();

		}
    });

	//set up the menu handlers
	setLeftMenuEvents('.left-menu');
	setRightMenuEvents('.right-menu');
	
	//set up the featured image
    setFeaturedImgCandy('div.featured-img.focuspoint img');

});
