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

	// menu handling
	$('.left-menu').click(function() {
		if ($('body').hasClass('is--pushed-left')){$('body').toggleClass('is--pushed-left')}
		$('body').toggleClass('is--pushed-right');
		$('article #abstract .trigger').toggleClass('is--hidden');
	});
	$('.right-menu').click(function() {
		$('.right-menu').toggleClass('trigger--active');
		if ($('body').hasClass('is--pushed-right')){$('body').toggleClass('is--pushed-right')};
		$('body').toggleClass('is--pushed-left');
	});

	//
	// Handle the featured image eye candy
	//
	//
	var $theImage = $('div.featured-img.focuspoint img')[0]

	// fire when image has loaded
	$('<img />').one('load', function() {


		// Set background of image to dominant image color
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
		$('div.featured-img.focuspoint').attr({
			"data-focus-x": focusPoint.x,
			"data-focus-y": focusPoint.y,
			"data-focus-w": imgData.w,
			"data-focus-h": imgData.h
		});
		$('.focuspoint').focusPoint();
		
		// set the text color based on the feature image background
		BackgroundCheck.init({
			minComplexity: 16,
			targets: '#abstract h1, #meta, #brand-link',
			images: $theImage
		});		
		
		// make the image appear
		$($theImage).removeClass('is--invisible').hide().fadeIn(1800, 'easeInOutQuad');	
		
	}).attr('src', $theImage.src);
	
});
