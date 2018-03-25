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

	// Article base.
	$wp_customize->add_setting( 'article_base', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_base', array(
		'section' => 'colors',
		'label'   => __( 'Article base color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'article_text', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_text', array(
		'section' => 'colors',
		'label'   => __( 'Article text color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'article_text_accent', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_text_accent', array(
		'section' => 'colors',
		'label'   => __( 'Article accent color', 'theme' ),
	) ) );

	// Hero Image.
	$wp_customize->add_setting( 'heroimg_base', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heroimg_base', array(
		'section' => 'colors',
		'label'   => __( 'Hero image base color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'heroimg_text', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heroimg_text', array(
		'section' => 'colors',
		'label'   => __( 'Hero image text color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'heroimg_text_accent', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heroimg_text_accent', array(
		'section' => 'colors',
		'label'   => __( 'Hero image accent color', 'theme' ),
	) ) );

	// Article list.
	$wp_customize->add_setting( 'article_list_base', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_list_base', array(
		'section' => 'colors',
		'label'   => __( 'Article list base color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'article_list_text', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_list_text', array(
		'section' => 'colors',
		'label'   => __( 'Article list text color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'article_list_text_accent', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_list_text_accent', array(
		'section' => 'colors',
		'label'   => __( 'Article list accent color', 'theme' ),
	) ) );

	// Navigation pane
	$wp_customize->add_setting( 'nav_base', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_base', array(
		'section' => 'colors',
		'label'   => __( 'Navigation base color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'nav_text', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_text', array(
		'section' => 'colors',
		'label'   => __( 'Navigation text color', 'theme' ),
	) ) );
	$wp_customize->add_setting( 'nav_text_accent', $color_setting_opts );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_text_accent', array(
		'section' => 'colors',
		'label'   => __( 'Navigation accent color', 'theme' ),
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
		'r' => $r,
		'g' => $g,
		'b' => $b,
	);
}

/**
 * Converts rgb to hsl color format
 * @param  int $r red value (0 to 255)
 * @param  int $g green value (0 to 255)
 * @param  int $b blue value (0 to 255)
 * @return array    hsl value as array [h,s,l]
 */
function big_cookbook_convert_rgb2hsl( $r, $g, $b ) {
	$r /= 255;
	$g /= 255;
	$b /= 255;

	$max = max( $r, $g, $b );
	$min = min( $r, $g, $b );
	$l   = ( $max + $min ) / 2;

	if ( $max == $min ) {
		$h = $s = 0;
	} else {
		$d = $max - $min;
		$s = $l > 0.5 ? $d / ( 2 - $max - $min ) : $d / ( $max + $min );
		switch ( $max ) {
			case $r:
				$h = ( $g - $b ) / $d + ( $g < $b ? 6 : 0 );
				break;
			case $g:
				$h = ( $b - $r ) / $d + 2;
				break;
			case $b:
				$h = ( $r - $g ) / $d + 4;
				break;
		}
		$h /= 6;
	}

	$h = floor( $h * 360 );
	$s = floor( $s * 100 );
	$l = floor( $l * 100 );

	return array(
		'h' => $h,
		's' => $s . '%',
		'l' => $l . '%',
	);
}

/**
 * converts hex to hsl color
 * @param  string $hex hexadecimal color
 * @return array      hsl value as array [h,s,l]
 * @see big_cookbook_convert_hex2rgb convert hex to rgb
 * @see big_cookbook_convert_rgb2hsl convert rgb to hsl
 */
function big_cookbook_convert_hex2hsl( $hex ) {
	$rgb = big_cookbook_convert_hex2rgb( $hex );
	return big_cookbook_convert_rgb2hsl( $rgb[ 'r' ], $rgb[ 'g' ], $rgb[ 'b' ] );
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
		$mod_value = big_cookbook_convert_hex2hsl( $mod_value );
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

	$article_base             = big_cookbook_get_clean_color_mod( 'article_base' );
	$article_text             = big_cookbook_get_clean_color_mod( 'article_text' );
	$article_text_accent      = big_cookbook_get_clean_color_mod( 'article_text_accent' );
	$heroimg_base             = big_cookbook_get_clean_color_mod( 'heroimg_base' );
	$heroimg_text             = big_cookbook_get_clean_color_mod( 'heroimg_text' );
	$heroimg_text_accent      = big_cookbook_get_clean_color_mod( 'heroimg_text_accent' );
	$article_list_base        = big_cookbook_get_clean_color_mod( 'article_list_base' );
	$article_list_text        = big_cookbook_get_clean_color_mod( 'article_list_text' );
	$article_list_text_accent = big_cookbook_get_clean_color_mod( 'article_list_text_accent' );
	$nav_base                 = big_cookbook_get_clean_color_mod( 'nav_base' );
	$nav_text                 = big_cookbook_get_clean_color_mod( 'nav_text' );
	$nav_text_accent          = big_cookbook_get_clean_color_mod( 'nav_text_accent' );

	ob_start();
	?>
	:root {
	<?php

	// Article.
	if ( ! empty( $article_base ) ) {
		?>
			--article-base: <?php echo esc_attr( $article_base ); ?>;
		<?php
	}
	if ( ! empty( $article_text ) ) {
		?>
			--article-text: <?php echo esc_attr( $article_text ); ?>;
		<?php
	}
	if ( ! empty( $article_text_accent ) ) {
		?>
			--article-text-accent: <?php echo esc_attr( $article_text_accent ); ?>;
		<?php
	}

	// Hero image.
	if ( ! empty( $heroimg_base ) ) {
		?>
			--heroimg-base: <?php echo esc_attr( $heroimg_base ); ?>;
		<?php
	}
	if ( ! empty( $heroimg_text ) ) {
		?>
			--heroimg-text: <?php echo esc_attr( $heroimg_text ); ?>;
		<?php
	}
	if ( ! empty( $heroimg_text_accent ) ) {
		?>
			--heroimg-text-accent: <?php echo esc_attr( $heroimg_text_accent ); ?>;
		<?php
	}

	// Article list.
	if ( ! empty( $article_list_base ) ) {
		?>
			--article-list-base: <?php echo esc_attr( $article_list_base ); ?>;
		<?php
	}
	if ( ! empty( $article_list_text ) ) {
		?>
			--article-list-text: <?php echo esc_attr( $article_list_text ); ?>;
		<?php
	}
	if ( ! empty( $article_list_text_accent ) ) {
		?>
			--article-list-text-accent: <?php echo esc_attr( $article_list_text_accent ); ?>;
		<?php
	}

	// Navigation. 
	if ( ! empty( $nav_base ) ) {
		?>
			--nav-base: <?php echo esc_attr( $nav_base ); ?>;
		<?php
	}
	if ( ! empty( $nav_text ) ) {
		?>
			--nav-text: <?php echo esc_attr( $nav_text ); ?>;
		<?php
	}
	if ( ! empty( $nav_text_accent ) ) {
		?>
			--nav-text-accent: <?php echo esc_attr( $nav_text_accent ); ?>;
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
