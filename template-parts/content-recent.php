<?php
/**
 * Template part creating a custom loop to display recent posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */


$default_posts_per_page = get_option( 'posts_per_page' );

$r = new WP_Query( apply_filters( 'widget_posts_args', array(
	'posts_per_page'      => $default_posts_per_page,
	'no_found_rows'       => true,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true
) ) );

if ($r->have_posts()) :

	while ( $r->have_posts() ) : $r->the_post();

		get_template_part('template-parts/content-thumb', get_post_format());

	endwhile;	

	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();

endif;	

?>