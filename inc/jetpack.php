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

function big_cookbook_jetpack_custom_support() {
    $supported = current_theme_supports( 'infinite-scroll' ) && ( is_home() || is_archive() || is_search() || is_singular() );
     
    return $supported;
}
//add_filter( 'infinite_scroll_archive_supported', 'big_cookbook_jetpack_custom_support' );

/**
 * Custom render function for Infinite Scroll.
 */
function big_cookbook_infinite_scroll_render()
{
    if ( is_singular() ) :
    // You'll need the custom loop
    
        get_template_part('template-parts/content', 'recent');

    else :
    // You're good with the normal loop
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content-thumb', get_post_format());
        }

    endif;
}

function big_cookbook_infinite_scroll_switch_to_custom_query(){

    //switch the IS query basis if you're on a singular page.
    if (is_singular()) {
        $default_posts_per_page = get_option( 'posts_per_page' );

        // set the number of posts to be the same number shown 
        // on the 'aside' of the main loop
        if ($default_posts_per_page > 3 ) : 
            $default_posts_per_page = $default_posts_per_page - 1;
        endif;

        if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
        elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
        else { $paged = 1; }


        $wp_query = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $default_posts_per_page,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'paged'               => $paged
        ) ) );
        if ($wp_query->have_posts()) :
            add_filter ( 'infinite_scroll_query_object', $wp_query );
        endif;  
    };
}
//add_action( 'the_post', 'big_cookbook_infinite_scroll_switch_to_custom_query' );
