'use strict';

jQuery( document ).ready( function( $ ) {

	var setLeftMenuEvents,
		setRightMenuEvents,
		setFeaturedImgCandy,
		loadArticle,
		closeAllMenus;

	/**
	 * jQuery Easing v1.3
	 * @copyright  2008 George McGinley Smith
	 * @license    Open source under the BSD License
	 * @see        http://gsgd.co.uk/sandbox/jquery/easing/
	 */
	$.easing.jswing = $.easing.swing;
	$.extend(
		$.easing,
		{
			def: 'easeOutQuad',
			swing: function( x, t, b, c, d ) { //Alert(jQuery.easing.default);
				return $.easing[$.easing.def]( x, t, b, c, d );
			},
			easeInQuad: function( x, t, b, c, d ) {
				return c * ( t /= d ) * t + b;
			},
			easeOutQuad: function( x, t, b, c, d ) {
				return -c * ( t /= d ) * ( t - 2 ) + b;
			},
			easeInOutQuad: function( x, t, b, c, d ) {
				if ( 1 > ( t /= d / 2 ) ) {
					return c / 2 * t * t + b;
				};
				return -c / 2 * ( ( --t ) * ( t - 2 ) - 1 ) + b;
			}
		}
	);

	/**
	 * Manages the opening anc closing of left hand menu
	 *
	 * @param {string} selector A jQuery compliant selector
	 */
	setLeftMenuEvents = function( selector ) {
		$( selector ).click( function clickLeftMenu() {
			if ( $( 'body' ).hasClass( 'is--pushed-left' ) ) {
				$( 'body' ).toggleClass( 'is--pushed-left' );
			}

			$( 'body' ).toggleClass( 'is--pushed-right' );
		});
	};

	/**
	 * Manages the opening anc closing of right hand menu
	 *
	 * @param {string} selector A jQuery compliant selector
	 */
	setRightMenuEvents = function( selector ) {
		$( selector ).click( function clickRightMenu() {
			$( '.right-menu' ).toggleClass( 'trigger--active' );

			if ( $( 'body' ).hasClass( 'is--pushed-right' ) ) {
				$( 'body' ).toggleClass( 'is--pushed-right' );
			}

			$( 'body' ).toggleClass( 'is--pushed-left' );
		});
	};

	/**
	 * Handler for the featured image.
	 *
	 * Ensures the appropriate part of an image is shown regardless
	 * of viewport orientation and size.
	 *
	 * @requires smartcrop.js
	 * @requires jquery.focuspoint.js
	 * @requires background-check.js
	 */
	setFeaturedImgCandy = function( selector ) {

		var $theImage;

		/**
		 * Calculates the center of a crop based on a topLeft origin coordinate based crop
		 * @param  {object} cropSize [description]
		 * @param  {object} imgSize  an object with 2 keys as w: imageWidth and h:imageHeight.
		 * @return {object}          an object with a focus point as x and y coordinate points
		 */
		var calcFocus = function( cropSize, imgSize ) {

			// Converting a topLeft origin with box coordinate axis to a center based coordinate one.
			var focusPt = {
				'x': ( ( cropSize.x + ( cropSize.width / 2 ) ) - ( imgSize.w / 2 ) ) / ( imgSize.w / 2 ),
				'y': ( ( imgSize.h / 2 ) - ( cropSize.y + ( cropSize.height / 2 ) ) ) / ( imgSize.h / 2 )
			};

			return focusPt;
		};

		// Check if something was actually passed to setFeaturedImgCandy
		if ( $( selector ).length ) {

			$theImage = $( selector )[0];

			// Load $theImage into a new Dom object and fire code once.
			$( '<img />' ).one( 'load', function() {

				var imgData, cropData, focusPoint;

				// 'this' references to the newly created <img />
				imgData = {
					w: this.width,
					h: this.height
				};

				/**
				 * Obtains an appropriate crop window (topLeft coordinate)
				 * @return {object}        {topCrop: {x: 300, y: 200, height: 200, width: 200}}
				 * @requires SmartCrop.js
				 */
				cropData = SmartCrop.crop( this,
					{
						'width': 250, // Keeping width slightly smaller than min-height
						'height': 250,
						'minScale': 0.9
					},
					function( result ) {
						return result;
					}
				);

				/**
				 * Set the focus point of the image
				 * @requires FocusPoint.js
				 */
				focusPoint = calcFocus( cropData.topCrop, imgData );
				$( $theImage ).parent().attr({
					'data-focus-x': focusPoint.x,
					'data-focus-y': focusPoint.y,
					'data-focus-w': imgData.w,
					'data-focus-h': imgData.h
				});
				$( $theImage ).parent().focusPoint();

				/**
				 * Set the text color based on the feature image background
				 * @requires BackgroundCheck.js
				 */
				BackgroundCheck.init({
					'minComplexity': 16,
					'targets': '#abstract h1, #meta, #brand-link',
					'images': $theImage
				});

				// Make the image appear
				$( $theImage )
					.removeClass( 'is--invisible' )
					.hide()
					.fadeIn( 1800, 'easeInOutQuad' );

			}).attr( 'src', $theImage.src );

		} // End of: if ( $( selector ).length )

	}; // End of: setFeaturedImgCandy

	/**
	 * Loads a given wordpress article into the DOM through AJAX
	 *
	 * @param  {integer} postId The wordpress post ID
	 */
	loadArticle = function( postId ) {
		jQuery.ajax(
			{
				'type': 'POST',
				'url': ajaxurl,
				'data': {
					'action': 'load_single_article',
					'post_id': postId
				},
				'beforeSend': function() {
					$( '.main.wrapper > article > header .featured-img' ).remove();
					$( '.main.wrapper > article > header #meta' ).remove();
					$( '.main.wrapper > article #article_body section' ).remove();
					$( '.main.wrapper > article #article_body footer' ).remove();

					$( '.main.wrapper > article > header h1' ).text( 'Loading article' );
					$( '.main.wrapper > article #article_body' ).prepend(
						'Please hold while we load the content'
					);
				},
				'success': function( response ) {
					$( '.main.wrapper > article' ).remove();
					$( '.main.wrapper' ).prepend( response );

					setLeftMenuEvents( '.main.wrapper > article .left-menu' );
					setRightMenuEvents( '#article_body .right-menu' );

					setFeaturedImgCandy( 'div.featured-img.focuspoint img' );
				}
			}
        );
	};

	/**
	 * Handles browswer history actions back|forward
	 * Required to maintain user experience when loading articles through AJAX
	 *
	 * @requires loadArticle()
	 */
	window.addEventListener( 'popstate', function( e ) {

		if ( null !==  e.state ) {

			// Close any open menus
			if ( $( 'body' ).hasClass( 'is--pushed-right' ) ) {
				$( '#blog-list .left-menu' ).trigger( 'click' );
			}
			if ( $( 'body' ).hasClass( 'is--pushed-left' ) ) {
				$( '#article_body .right-menu' ).trigger( 'click' );
			}

			loadArticle( e.state.post );

			// NOTE: This may not be exactly the same formatting rules as WordPress page titles.
			document.title = e.state.title + ' | ' + window.location.hostname;
		}
	});

	/**
	 * Suppress hyperlink events in favor of AJAX loading where appropriate
	 *
	 * @requires loadArticle()
	 */
	$( 'a.ajax-load-article' ).click( function( e ) {

		var postId, postTitle;

		// Allow people to follow cmd/ctrl clicks
		if ( event.metaKey || event.ctrlKey ) {
			return true;

		// It's a normal click
		} else {

			e.preventDefault();

			postId = $( this ).attr( 'id' ).slice( 5 );
			postTitle = $( this ).find( 'h1' ).first().text();

			// Set browser history
			history.pushState(
				{
					'title': postTitle,
					'post': postId
				},
				null,
				$( this ).attr( 'href' )
			);

			loadArticle( postId );
			setTimeout( function() {
				$( '#blog-list .left-menu' ).trigger( 'click' );
			}, 500 );

			// NOTE: This may not be exactly the same formatting rules as WordPress page titles.
			document.title = document.title = postTitle + ' | ' + window.location.hostname;

			e.stopPropagation();
		}
	});

	// Set up the menu handlers
	setLeftMenuEvents( '#abstract', '.left-menu' );
	setRightMenuEvents( '.right-menu' );

	// Set up the featured image
	setFeaturedImgCandy( 'div.featured-img.focuspoint img' );
});
