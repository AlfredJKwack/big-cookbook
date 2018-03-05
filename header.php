<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <article id="post-xxxx">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?><!DOCTYPE html>
<!--[if lt IE 8]>      <html class="no-js lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie8"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <a class="skip-link screen-reader-text" href="#article_body"><?php esc_html_e('Skip to content', 'big-cookbook'); ?></a>
    <div class="main-container">
        <div class="site-brand-container">
            <header id="brand-wrapper" class="wrapper clearfix">

                <h1 class="title">
                    <a id="brand-link" class="button" rel="home" href="<?php echo esc_url(home_url('/')); ?>">                  
                    <?php if ( get_header_image() ) : ?>
                        <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else : // End header image check. ?>
                        <span><?php bloginfo('name'); ?></span>
                    <?php endif; // End header text display. ?>
                    
                    </a>
                </h1>

            </header>
        </div>
        <div class="main wrapper clearfix">