<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 * @package big-cookbook\tempate-parts
 */

if ( 0 === $wp_query->current_post && ! is_paged() ) {
	/* first post */ ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<div class="featured-img focuspoint">                
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full', array( 'class' => 'is--invisible' ) );
				}
				?>
			</div>
			<div id="abstract">
				<?php
				the_title( ' <h1 class="entry-title">', '</h1>' );
				if ( 'post' === get_post_type() ) :
				?>
					<div id="meta">
		<?php big_cookbook_posted_on(); ?>
					</div><!-- #meta -->
				<?php
				endif;
				?>
				<a href="javascript:void(0)" class="left-menu button trigger more"><span>More recipes</span></a>
				<a href="javascript:void(0)" class="left-menu button trigger less">Continue reading</a>
			</div>
		</header><!-- .entry-header -->
		<div id="article_body">
			<a id="" href="javascript:void(0)" class="right-menu button trigger"><span>&equiv;</span></a>
			<section>
				<?php
					the_content(
						sprintf(
							/* translators: %s: Name of current post. */
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'big-cookbook' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'big-cookbook' ),
							'after'  => '</div>',
						)
					);
		?>
			</section>
			<footer class="entry-footer">
				<?php big_cookbook_entry_footer(); ?>
			</footer><!-- .entry-footer -->                
		</div><!-- #article_body -->
	</article>

	<aside id="article_list" class="">
		<h1>More Articles</h1>
		<div id="blog-list">

<?php
} else { /* not first post */
?>

	<div class="col col--6">

	<?php
	$entry_permalink = '<a href="%1$s" class="list-item list-item--stacked">';
	$entry_permalink = sprintf(
		$entry_permalink,
		esc_url( get_permalink() )
	);

	echo $entry_permalink; // WPCS: XSS ok.
	?>
			<div class="thumbnail">
				<div class="image-wrapper content-fill" style="overflow: hidden;">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'category-thumb' );
		}
		?>
				</div>
			</div>  

			<div class="list-item-text">
				<?php the_title( '<h1 class="title">', '</h1>' ); ?>

				<div class="excerpt"><?php the_excerpt(); ?></div>

				<div class="list-item-meta">

		<?php

		$time_label = '<time class="date" datetime="%1$s">%2$s</time>';

		$time_label = sprintf(
			$time_label,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
					echo $time_label // WPCS: XSS ok.
		?>

				</div>
			</div><!-- .list-item-text -->
		</a><!-- .list-item -->
	</div>

<?php
}
?>
