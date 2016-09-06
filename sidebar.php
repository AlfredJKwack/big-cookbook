<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>


        <nav id="navigation_main" role="navigation" class="background--dark">
			<?php dynamic_sidebar('sidebar-1'); ?>
            <a href="javascript:void(0)" class="right-menu button trigger"><span>X</span></a>
        </nav>
