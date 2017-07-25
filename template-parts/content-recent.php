<?php
/**
 * Template part creating a custom loop to display recent posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$r = big_cookbook_get_custom_query();

if ($r->have_posts()) :

	while ( $r->have_posts() ) : $r->the_post();

		get_template_part('template-parts/content-thumb', get_post_format());

	endwhile;	

	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();

endif;	

?>