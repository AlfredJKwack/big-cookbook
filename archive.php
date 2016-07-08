<?php
/**
 * The template for displaying archive pages.
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
						
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
						<div id="blog-list">
						
					<?php

				else :
					/* not first post */
					get_template_part( 'template-parts/content-thumb', get_post_format() );

				endif;

			endwhile;

			?>
							<a href="javascript:void(0)" class="left-menu button trigger">close</a>		
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
