<?php
/**
 * Template part creating a custom loop to display recent posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */


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

	// Jetpack integration: change its base query reference
	// if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) :
	// 	add_filter ( 'infinite_scroll_query_object', $wp_query );
	// 	?>  <!-- HELLO --> <?php
	// endif;	

	while ( $wp_query->have_posts() ) : $wp_query->the_post();

		get_template_part('template-parts/content-thumb', get_post_format());

	endwhile;	

	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();

	 // Jetpack integration: change its base query reference
	// if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) :
	// 	add_filter ( 'infinite_scroll_query_object', $GLOBALS['wp_the_query'] );
	// endif;	

endif;	

?>