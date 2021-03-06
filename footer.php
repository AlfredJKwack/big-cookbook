<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package big-cookbook
 */

?>
	<footer id="colophon" class="site-footer is--hidden" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'big-cookbook' ) ); ?>">
				<?php
				// translators: who's the cool cat?
				printf( esc_html__( 'Proudly powered by %s', 'big-cookbook' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
			<?php
			// translators: Theme designer note?
			printf( esc_html__( 'Theme: %1$s by %2$s.', 'big-cookbook' ), 'big-cookbook', '<a href="http://www.badsoda.com" rel="designer">Thomas Vanparys</a>' );
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
