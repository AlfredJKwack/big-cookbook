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

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */

				/*
				if ( $wp_query->current_post == 0 && !is_paged() ) :  
				*/
				if ( $wp_query->current_post == 0) : 
					/* first post */
					get_template_part( 'template-parts/content-article', get_post_format() );

					?>
					<aside id="article_list" class="">
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
							<a href="#" class="left-menu button trigger">close</a>		
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
