<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Big_Cookbook
 */

get_header(); ?>


		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();


				if ( $wp_query->current_post == 0) : 
					/* first post */
					get_template_part( 'template-parts/content-article', get_post_format() );

					?>
					<aside id="article_list" class="">

						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>

						<h1>More Articles</h1>
						<div id="blog-list">
					<?php

				else :
					/* not first post */
					get_template_part( 'template-parts/content-thumb', get_post_format() );

				endif;

			endwhile;

			?>	
						</div><!-- #blog-list -->
					</aside><!-- #article_list -->
			<?php			


		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
					

		</div> <!-- #main -->
	</div> <!-- #main-container -->

<?php
get_sidebar();
get_footer();
