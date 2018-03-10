<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package big-cookbook
 */

get_header(); ?>

		<?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				if ( 0 === $wp_query->current_post ) :
					/* first post */
					get_template_part( 'template-parts/content-article', get_post_format() );

					?>
					<aside id="article_list" class="">
						<?php
						get_template_part( 'template-parts/content', 'primarymenu' );
						?>
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
		endif;
		?>

		</div> <!-- #main -->
	</div> <!-- #main-container -->

<?php
get_sidebar();
get_footer();
