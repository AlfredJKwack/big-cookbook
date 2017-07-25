<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function big_cookbook_jetpack_setup()
{
    // Add theme support for Infinite Scroll.
    add_theme_support('infinite-scroll', array(
        'container' => 'blog-list"',
        'render' => 'big_cookbook_infinite_scroll_render',
        'footer' => false,
        'type' => 'click',
        'wrapper' => false,
    ));

    // Add theme support for Responsive Videos.
    add_theme_support('jetpack-responsive-videos');
}
add_action('after_setup_theme', 'big_cookbook_jetpack_setup');

/**
 * Custom render function for Infinite Scroll.
 */
function big_cookbook_infinite_scroll_render()
{
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content-thumb', get_post_format());
    }
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
 * Sets Infinite Scroll's query object if necessary. 
 */
function big_cookbook_force_batch() { return false; };
function big_cookbook_infinite_scroll_set_query_ref(){

    if ( is_singular() ) {
        add_filter ( 'infinite_scroll_query_object', 'big_cookbook_get_custom_query' );
        add_filter ( 'infinite_scroll_is_last_batch', 'big_cookbook_force_batch' );
    }
}
add_action( 'template_redirect','big_cookbook_infinite_scroll_set_query_ref',1);
