<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

function is_search_has_results() {
    // helper function to determine whether the searh yielded results 
    return 0 != $GLOBALS['wp_query']->found_posts;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element
 *
 * @return array
 */
function big_cookbook_body_classes($classes)
{
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of is--pushed-right to archives and categories
    if ( ( is_archive() or is_category() or is_paged() or is_search_has_results() ) and !is_singular() ) {
        $classes[] = 'is--pushed-right';
    }

    return $classes;
}
add_filter('body_class', 'big_cookbook_body_classes');
