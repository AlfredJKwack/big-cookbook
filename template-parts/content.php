<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Big_Cookbook
 */

?>

<?php
	if( $wp_query->current_post == 0 && !is_paged() ) { 
	/* first post */ ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<div class="featured-img focuspoint">				
					<?php 
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'full', array( 'class' => 'is--invisible' ) ); 
					}; ?>
				</div>
				<div id="abstract">
					<?php 
					the_title( '<h1 class="entry-title">', '</h1>' ); 
					if ( 'post' === get_post_type() ) : ?>
						<div id="meta">
							<?php big_cookbook_posted_on(); ?>
						</div><!-- #meta -->
					<?php
					endif; ?>
					<a href="#" class="left-menu button trigger"><span>Left Menu</span></a>
				</div>
			</header><!-- .entry-header -->
			<div id="article_body">
				<a id="" href="#" class="right-menu button trigger"><span>&equiv;</span></a>
				<section>
					<?php
						the_content( sprintf(
							/* translators: %s: Name of current post. */
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'big-cookbook' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'big-cookbook' ),
							'after'  => '</div>',
						) );
					?>					
				</section>
				<footer class="entry-footer">
					<?php big_cookbook_entry_footer(); ?>
				</footer><!-- .entry-footer -->				
			</div><!-- #article_body -->
		</article>

		<aside id="article_list" class="is--fadeable">
			<h1>More Articles</h1>
			<div id="blog-list">

<?php
	} else {
	/* not first post */ ?>




		<div class="col col--6">

			<a href="<?php esc_url( get_permalink() ) ?>" class="list-item list-item--stacked">
				  
				    <div class="thumbnail" style="background-color: #131723">
				      <div class="image-wrapper content-fill" style="overflow: hidden;">
							<?php 
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium', array( 'class' => '' ) ); 
							}; ?>
				      </div>
				    </div>
				  

				<div class="list-item-text">
					<?php the_title( '<h1 class="title">', '</h1>' ); ?>

					<div class="excerpt"><?php the_excerpt () ?></div>

					<div class="list-item-meta">
						<time class="date" datetime="<?php get_the_modified_date( 'c' ) ?>"> <?php get_the_modified_date() ?> </time>
					</div>
				</div>
			</a>
		</div>
		<a href="#" class="left-menu button trigger">close</a>

<?php
	}
?>
