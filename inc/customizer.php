<?php
/**
 * Big Cookbook Theme Customizer.
 *
 * @package big-cookbook
 */

/**
 * Add support for theme specific customizations.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function big_cookbook_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$color_setting_opts = array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	);

	// Article accent color.
	$wp_customize->add_setting( 'article_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Article accent color', 'theme' ),
	) ) );

	// Article opposite accent color.
	$wp_customize->add_setting( 'article_opposite_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_opposite_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Article invert accent color', 'theme' ),
	) ) );

	// Text accent color.
	$wp_customize->add_setting( 'text_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Text accent color', 'theme' ),
	) ) );

	// Hero image accent color.
	$wp_customize->add_setting( 'heroimg_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heroimg_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Hero image accent color', 'theme' ),
	) ) );

	// Navigation accent color.
	$wp_customize->add_setting( 'nav_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Navigation accent color', 'theme' ),
	) ) );

	// Article list accent color.
	$wp_customize->add_setting( 'articlelist_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'articlelist_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Article list accent color', 'theme' ),
	) ) );

	// Hero & Nav accent color.
	$wp_customize->add_setting( 'heronav_opposite_accent_color', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heronav_opposite_accent_color', array(
		'section' => 'colors',
		'label'   => __( 'Hero image and nav invert accent color', 'theme' ),
	) ) );

}
add_action( 'customize_register', 'big_cookbook_customize_register' );

/**
 * Converts a hexadecimal color to rgb format
 *
 * @param  string $hex Hexadecimal color representation.
 * @return array       Red green blue array.
 */
function big_cookbook_convert_hex2rgb( $hex ) {

	if ( '#' === $hex[0] ) {
			$hex = substr( $hex, 1 );
	}
	if ( 6 === strlen( $hex ) ) {
			list( $r, $g, $b ) = array( $hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5] );
	} elseif ( 3 === strlen( $hex ) ) {
			list( $r, $g, $b ) = array( $hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2] );
	} else {
			return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Gets a theme color mod and formats is for output.
 *
 * @param  string $name Theme modification parameter name.
 * @return string       RBG string.
 */
function big_cookbook_get_clean_color_mod( $name ) {
	$mod_value = get_theme_mod( $name, '' );
	if ( '' !== $mod_value ) {
		$mod_value = big_cookbook_convert_hex2rgb( $mod_value );
		$mod_value = implode( ',', $mod_value );
	};
	return $mod_value;
}

/**
 * Prepare custom colors for output.
 *
 * @see big_cookbook_customize_register
 */
function big_cookbook_get_customizer_css() {

	$article_accent_color          = big_cookbook_get_clean_color_mod( 'article_accent_color' );
	$articlelist_accent_color      = big_cookbook_get_clean_color_mod( 'articlelist_accent_color' );
	$heroimg_accent_color          = big_cookbook_get_clean_color_mod( 'heroimg_accent_color' );
	$nav_accent_color              = big_cookbook_get_clean_color_mod( 'nav_accent_color' );
	$article_opposite_accent_color = big_cookbook_get_clean_color_mod( 'article_opposite_accent_color' );
	$heronav_opposite_accent_color = big_cookbook_get_clean_color_mod( 'heronav_opposite_accent_color' );
	$text_accent_color             = big_cookbook_get_clean_color_mod( 'text_accent_color' );

	ob_start();
	?>
	:root {
	<?php

	if ( ! empty( $article_accent_color ) ) {
		?>
			--article-accent: <?php echo esc_attr( $article_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $articlelist_accent_color ) ) {
		?>
			--articlelist-accent: <?php echo esc_attr( $articlelist_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $heroimg_accent_color ) ) {
		?>
			--heroimg-accent: <?php echo esc_attr( $heroimg_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $nav_accent_color ) ) {
		?>
			--nav-accent: <?php echo esc_attr( $nav_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $article_opposite_accent_color ) ) {
		?>
			--article-opposite-accent: <?php echo esc_attr( $article_opposite_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $heronav_opposite_accent_color ) ) {
		?>
			--heronav-opposite-accent: <?php echo esc_attr( $heronav_opposite_accent_color ); ?>;
		<?php
	}
	if ( ! empty( $text_accent_color ) ) {
		?>
			--text-accent: <?php echo esc_attr( $text_accent_color ); ?>;
		<?php
	}
	?>
	}
	<?php
	$css = ob_get_clean();
	return $css;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function big_cookbook_customize_preview_js() {
	wp_enqueue_script(
		'big_cookbook_customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		'20151215',
		true
	);
}
add_action( 'customize_preview_init', 'big_cookbook_customize_preview_js' );
