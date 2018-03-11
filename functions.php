<?php
/**
 * Big Cookbook functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package big-cookbook
 */

if ( ! function_exists( 'big_cookbook_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function big_cookbook_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Big Cookbook, use a find and replace
		 * to change 'big-cookbook' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'big-cookbook', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'category-thumb', 460, 9999 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__( 'Primary', 'big-cookbook' ),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		));
	}
endif;
add_action( 'after_setup_theme', 'big_cookbook_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width

function big_cookbook_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'big_cookbook_content_width', 640 );
}
add_action( 'after_setup_theme', 'big_cookbook_content_width', 0 );
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @uses register_sidebar
 */
function big_cookbook_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__( 'Sidebar', 'big-cookbook' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action( 'widgets_init', 'big_cookbook_widgets_init' );

/**
 * Enqueue important styles.
 *
 * @uses wp_enqueue_style
 */
function big_cookbook_scripts_important() {
	wp_enqueue_style( 'normalize-css', get_template_directory_uri() . '/lib/vendor/normalize.min.css', array() );
}
add_action( 'wp_enqueue_scripts', 'big_cookbook_scripts_important', 5 );

/**
 * Enqueue other scripts and styles.
 *
 * @uses wp_enqueue_style, wp_enqueue_script
 */
function big_cookbook_scripts() {
	wp_enqueue_script( 'jquery' );

	wp_enqueue_style( 'big-cookbook-style', get_stylesheet_uri() );

	wp_enqueue_style( 'focuspoint', get_template_directory_uri() . '/lib/vendor/focuspoint.min.css', array() );

	wp_enqueue_script( 'focuspoint', get_template_directory_uri() . '/lib/vendor/jquery-focuspoint.min.js', array() );

	wp_enqueue_script( 'smartcrop', get_template_directory_uri() . '/lib/vendor/smartcrop.min.js', array() );

	wp_enqueue_script( 'background-check', get_template_directory_uri() . '/lib/vendor/background-check.min.js', array() );

	wp_enqueue_script( 'big-cookbook-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'big-cookbook-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'big-cookbook-main', get_template_directory_uri() . '/js/main.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'big_cookbook_scripts' );

/**
 * Set a javascript variable indicating where the ajax calls should go.
 */
function add_ajaxurl_cdata_to_front() {
	?>
	<script type="text/javascript"> //<![CDATA[
		ajaxurl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
	//]]> </script>
	<?php
}
add_action( 'wp_head', 'add_ajaxurl_cdata_to_front', 1 );

/**
 * Load single articles through ajax calls.
 */
function load_single_article() {
	global $post; // since setup_postdata needs this.
	$post_id = $_POST['post_id'];
	$post    = get_post( $post_id, OBJECT );

	ob_start(); // start caputring output.

	if ( ! $post || ( get_post_status( $post_id ) === 'private' ) ) {
		get_template_part( 'template-parts/content', 'none' );
	} else {
		setup_postdata( $post );
		get_template_part( 'template-parts/content-article', get_post_format() );
		wp_reset_postdata();
	}

	$content = ob_get_clean();
	echo $content;

	die();
}
add_action( 'wp_ajax_load_single_article', 'load_single_article' );
add_action( 'wp_ajax_nopriv_load_single_article', 'load_single_article' );

/**
 * Change the excerpt length to something suitable for this theme.
 *
 * @param int $length length of the excerpt.
 */
function big_cookbook_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'big_cookbook_excerpt_length', 999 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Enqueue customizer CCS additions.
 */
function big_cookbook_customizer_scripts() {
	$custom_css = big_cookbook_get_customizer_css();
	wp_add_inline_style( 'big-cookbook-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'big_cookbook_customizer_scripts' );

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if ( ! function_exists( 'big_cookbook_get_custom_query' ) ) :
	/**
	 * Returns a custom query object.
	 */
	function big_cookbook_get_custom_query() {

		$default_posts_per_page = get_option( 'posts_per_page' );

		// set the number of posts to be the same number shown
		// on the 'aside' of the main loop.
		if ( $default_posts_per_page > 3 ) :
			$default_posts_per_page = $default_posts_per_page--;
		endif;

		// set the pagination if available.
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		// build out our query.
		return new WP_Query( array(
			'posts_per_page'      => $default_posts_per_page,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'paged'               => $paged,
		) );

		// ATTENTION: wp_reset_postdata() has not been run!
	}
endif;
