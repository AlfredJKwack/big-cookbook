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
		hex2rgb,
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
	 * Converts WP hex color to rgb string.
	 * @param  {string} hex color in hex form.
	 * @return {string}     RGB color number string.
	 */
	hexToRgb = function( hex ) {
		var result,
			shorthandRegex;

		console.log('hexToRgb ran:' + hex)
		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace( shorthandRegex, function( m, r, g, b ) {
			return r + r + g + g + b + b;
		});

		result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );
		return result ? (
			parseInt( result[1], 16 ) + ',' +
			parseInt( result[2], 16 ) + ',' +
			parseInt( result[3], 16 )
		) : null;
	};

	/**
	 * Set CSS properties on body to defined value.
	 * @param {string} prop    CSS property name.
	 * @param {string} currVal Hex color value.
	 * @param {sting}  defVal  Default value (rbg).
	 */
	setCssParam = function( prop, currVal, defVal ) {
		if ( 0 === currVal.length ) {
			document.body.style.setProperty( prop, defVal );
		} else {
			document.body.style.setProperty( prop, hexToRgb( currVal ) );
		}
	};

	// Show main article when setting article accent color.
	wp.customize( 'article_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--article-accent', to, '246,246,246' );
		});
	});

	// Show article list when setting list color.
	wp.customize( 'articlelist_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewPushRight();
			setCssParam( '--articlelist-accent', to, '238,238,238' );
		});
	});

	// Show hero image with article list.
	wp.customize( 'heroimg_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewPushRight();
			setCssParam( '--heroimg-accent', to, '169, 169, 169' );
		});
	});

	// Show navigation pane when setting accent color.
	wp.customize( 'nav_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--nav-accent', to, '49,49,49' );
		});
	});

	// Show article when messing with top colors.
	wp.customize( 'article_opposite_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--article-opposite-accent', to, '49,49,49' );
		});
	});

	// Now navigation wthen messing with top colors.
	wp.customize( 'heronav_opposite_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewPushLeft();
			setCssParam( '--heronav-opposite-accent', to, '246,246,246' );
		});
	});

	// Show article when messing with text color.
	wp.customize( 'text_accent_color', function( value ) {
		value.bind( function( to ) {
			setViewNormal();
			setCssParam( '--text-accent', to, '153, 0, 51' );
		});
	});

})( jQuery );
