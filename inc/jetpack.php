<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 * @package big-cookbook\inc
 */

/**
 * Jetpack setup functions.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 *
 * @uses  add_theme_support
 */
function big_cookbook_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll', array(
			'container'      => 'blog-list',
			'render'         => 'big_cookbook_infinite_scroll_render',
			'footer_widgets' => false,
			'type'           => 'click',
			'wrapper'        => false,
			'posts_per_page' => 10,
		)
	);

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'big_cookbook_jetpack_setup' );

/**
 * Remove sharing buttons from tiles/excerpts.
 */
function jptweak_remove_share() {
	// leaving this causes issues on 404/isSingle due to custom loop.
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'jptweak_remove_share' );


/**
 * Custom render function for Infinite Scroll.
 */
function big_cookbook_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content-thumb', get_post_format() );
	}
	// Reset the global $the_post as the custom query will have stomped on it.
	wp_reset_postdata();
}

/**
 * Customize the page types supported through Infinite Scroll.
 */
function big_cookbook_jetpack_custom_support() {
	$supported = current_theme_supports( 'infinite-scroll' ) && ( is_home() || is_archive() || is_search() || is_singular() );

	return $supported;
}
add_filter( 'infinite_scroll_archive_supported', 'big_cookbook_jetpack_custom_support' );


/**
 * Falsy.
 */
function big_cookbook_force_batch() {
	return false;
}

/**
 * Sets Infinite Scroll's query object if necessary.
 *
 * @uses  add_filter
 */
function big_cookbook_infinite_scroll_set_query_ref() {

	if ( is_singular() ) {
		add_filter( 'infinite_scroll_query_object', 'big_cookbook_get_custom_query' );
		add_filter( 'infinite_scroll_is_last_batch', 'big_cookbook_force_batch' );
	}
}
add_action( 'template_redirect', 'big_cookbook_infinite_scroll_set_query_ref', 1 );
