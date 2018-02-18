<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package big-cookbook
 */

get_header(); ?>


		<?php

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/* display the page post */
			get_template_part( 'template-parts/content', 'page' );

			?>
			<aside id="article_list" class="">
				<?php
				get_template_part( 'template-parts/content', 'primarymenu' );
				?>
				<div id="blog-list">
			<?php

			/* put recent articles in the article list */
			get_template_part( 'template-parts/content', 'recent' );

		endwhile;
		?>
					</div><!-- #blog-list -->
				</aside><!-- #article_list -->
		</div> <!-- #main -->
	</div> <!-- #main-container -->

<?php
get_sidebar();
get_footer();
