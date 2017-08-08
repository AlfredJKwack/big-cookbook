<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package big-cookbook
 */

get_header(); ?>
	
		<article class="error-404 not-found">
			<header class="page-header">
				<div class="featured-img focuspoint">                
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/404.png" alt="404 Error image" />
				</div>
				<div id="abstract">
					<h1 class="page-title"><?php esc_html_e( 'Oops! It looks like that page is toast.', 'big-cookbook' ); ?></h1>

					<a href="javascript:void(0)" class="left-menu button trigger more"><span>More recipes</span></a>

					<a href="javascript:void(0)" class="left-menu button trigger less">Continue reading</a>

				</div>
			</header><!-- .page-header -->
			<div id="article_body">

				<a id="" href="javascript:void(0)" class="right-menu button trigger"><span>&equiv;</span></a>

				<section>
					<p><?php esc_html_e( 'It seems like there is nothing pertinent at this location. Maybe try a search?', 'big-cookbook' ); ?></p>

					<?php
					get_search_form();
					?>
					<br/>

				</section>
			</div><!-- #article_body -->
		</article><!-- .error-404 not-found ?> -->

		<aside id="article_list" class="">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			<h1>More Articles</h1>
			<div id="blog-list">
			<?php

			/* put recent articles in the article list */
			get_template_part( 'template-parts/content', 'recent' );

			?>
			</div><!-- #blog-list -->
		</aside><!-- #article_list -->

		</div> <!-- #main -->
	</div> <!-- #main-container -->
<?php
get_sidebar();
get_footer();
