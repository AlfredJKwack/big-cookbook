<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Big_Cookbook
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>


        <nav id="navigation_main" role="navigation" class="is--fadeable">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
            <a href="#" class="right-menu button trigger">close</a>
        </nav>
