/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	var setViewNormal,
		setViewLeft,
		setViewRight,
		hexToRgb,
		rgbToHsl,
		hexToHsl,
		setCssParam;

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		});
	});
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		});
	});

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$( '.site-title a, .site-description' ).css({
					'clip': 'auto',
					'position': 'relative'
				});
				$( '.site-title a, .site-description' ).css({
					'color': to
				});
			}
		});
	});

	// Slide panels right/left/normal.
	// Useful to display the area being modified.
	setViewNormal = function() {
		$( 'body' ).removeClass( 'is--pushed-left is--pushed-right' );
	};
	setViewPushLeft = function() {
		$( 'body' ).removeClass( 'is--pushed-left is--pushed-right' );
		$( 'body' ).addClass( 'is--pushed-left' );
	};
	setViewPushRight = function() {
		$( 'body' ).removeClass( 'is--pushed-left is--pushed-right' );
		$( 'body' ).addClass( 'is--pushed-right' );
	};


	/**
	 * Expand shorthand hex form (e.g. "03F") to full form (e.g. "0033FF").
	 * @param  {str}    hex color in hex form
	 * @return {string}     color in long hex form
	 */
	function hex2longHex( hex ) {
		shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace( shorthandRegex, function( m, r, g, b ) {
			return r + r + g + g + b + b;
		});
	};

	/**
	 * Converts WP hex color to rgb string.
	 * @param  {string} hex color in hex form.
	 * @return {string}     RGB color number string.
	 */
	hexToRgb = function( hex ) {
		var result,
			shorthandRegex;

		result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );
		return result ? (
			parseInt( result[1], 16 ) + ',' +
			parseInt( result[2], 16 ) + ',' +
			parseInt( result[3], 16 )
		) : null;
	};

	/**
	 * converts rgb to hsl color
	 * @param  {int} r red color value 0 to 255
	 * @param  {int} g green color value 0 to 255
	 * @param  {int} b blue color value 0 to 255
	 * @return {object}   color in hsl form ('h, s%, l%')
	 */
	rgbToHsl = function( r, g, b ) {
		var max, min, h, s, l, d;
		r  /= 255;
		g  /= 255;
		b  /= 255;

		max = Math.max( r, g, b );
		min = Math.min( r, g, b );
		l   = ( max + min ) / 2;

		if ( max == min ) {
			h = s = 0;
		} else {
			d = max - min;
			s = l > 0.5 ? d / ( 2 - max - min ) : d / ( max + min );
			switch ( max ) {
				case r:
					h = ( g - b ) / d + ( g < b ? 6 : 0 );
					break;
				case g:
					h = ( b - r ) / d + 2;
					break;
				case b:
					h = ( r - g ) / d + 4;
					break;
			}
			h /= 6;
		}

		h = Math.floor( h * 360 );
		s = Math.floor( s * 100 );
		l = Math.floor( l * 100 );

		return {
			h: h,
			s: s + '%',
			l: l + '%'
		};
	};

	/**
	 * Converts hex to hsl color.
	 * @param  {string} hex color in hex form.
	 * @return {string}     color in hsl form ('h, s%, l%')
	 */
	hexToHsl = function ( hex ) {
		var rgb = hexToRgb( hex ).split( ',');
		return rgbToHsl( rgb[0], rgb[1], rgb[2] );
	};

	/**
	 * Returns contrasting color should be dark or light.
	 * @param  {string} hex  color in hex form.
	 * @return {string}      black or white.
	 */
	function getContrastYIQ( hex ){
		var r, g, b;
		hex = replace( '#', '' );
		var r = parseInt( hex.substr( 0,2 ), 16 );
		var g = parseInt( hex.substr( 2,2 ), 16 );
		var b = parseInt( hex.substr( 4,2 ), 16 );
		var yiq = ((r*299)+(g*587)+(b*114))/1000;
		return (yiq >= 128) ? 'black' : 'white';
	}

	/**
	 * Set CSS properties on body to defined value.
	 * @param {string} prop    CSS property name.
	 * @param {string} currVal Hex color value.
	 * @param {sting}  defVal  Default value (rbg).
	 */
	setCssParam = function( prop, currVal, defVal ) {
		var hsl;
		if ( 0 === currVal.length ) {
			document.body.style.setProperty( prop, defVal );
		} else {
			hsl = hexToHsl( currVal );
			document.body.style.setProperty( prop, ( hsl.h + ',' + hsl.s + ',' + hsl.l ) );
		}
	};

	// Article.
	wp.customize( 'article_base', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--article-base', to, '20, 100%, 65%' );
		});
	});
	wp.customize( 'article_text', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--article-text', to, '19, 73%, 20%' );
		});
	});
	wp.customize( 'article_text_accent', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--article-text-accent', to, '20, 100%, 50%' );
		});
	});

	// Hero image.
	wp.customize( 'heroimg_base', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--heroimg-base', to, '259, 100%, 76%' );
		});
	});
	wp.customize( 'heroimg_text', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--heroimg-text', to, '258, 73%, 20%' );
		});
	});
	wp.customize( 'heroimg_text_accent', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--heroimg-text-accent', to, '259, 100%, 50%' );
		});
	});

	// Article list.
	wp.customize( 'article_list_base', function( value ) {
		value.bind( function( to ) {
			setViewPushRight();
			setCssParam( '--article-list-base', to, '180, 100%, 44%' );
		});
	});
	wp.customize( 'article_list_text', function( value ) {
		value.bind( function( to ) {
			setViewPushRight();
			setCssParam( '--article-list-text', to, '180, 100%, 18%' );
		});
	});
	wp.customize( 'harticle_list_text_accent', function( value ) {
		value.bind( function( to ) {
			setViewPushRight();
			setCssParam( '--article-list-text-accent', to, '180, 100%, 28%' );
		});
	});

	// Navigation pane.
	wp.customize( 'nav_base', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--nav-base', to, '121, 100%, 9%' );
		});
	});
	wp.customize( 'nav_text', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--nav-text', to, '121, 100%, 32%' );
		});
	});
	wp.customize( 'nav_text_accent', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--nav-text-accent', to, '121, 100%, 46%' );
		});
	});

})( jQuery );
