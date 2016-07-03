<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Big_Cookbook
 */

get_header(); ?>


		<?php

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/* display the post post */
			get_template_part( 'template-parts/content-article', get_post_format() );

			?>
			<aside id="article_list" class="">
				<h1>More Articles</h1>
				<div id="blog-list">
			<?php

			/* put something in the article list */

			$archive_args = array(
				'type'            => 'monthly',
				'limit'           => '',
				'format'          => 'html', 
				'before'          => '',
				'after'           => '',
				'show_post_count' => false,
				'echo'            => 1,
				'order'           => 'DESC'
			);
			wp_get_archives( $archive_args );

		endwhile;
		?>
						<a href="javascript:void(0)" class="left-menu button trigger">close</a>		
					</div><!-- #blog-list -->
				</aside><!-- #article_list -->
		</div> <!-- #main -->
	</div> <!-- #main-container -->

<?php
get_sidebar();
get_footer();
