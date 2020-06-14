<?php
/**
 * Interconnection functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Interconnection
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'interconnection_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function interconnection_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Interconnection, use a find and replace
		 * to change 'interconnection' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'interconnection', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'interconnection' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title'), // option to hide site title
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'interconnection_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function interconnection_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'interconnection_content_width', 1024 );
}
add_action( 'after_setup_theme', 'interconnection_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function interconnection_widgets_init() {
	// call to action widget
	register_sidebar(
		array(
			'name'          => esc_html__( 'Call to action', 'interconnection' ),
			'id'            => 'cta-1',
			'description'   => esc_html__( 'Add widgets here.', 'interconnection' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	// widget area for footer used in footer.php
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'interconnection' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'interconnection' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);
	// special notice for single posts
	register_sidebar(
		array(
			'name'          => esc_html__( 'Special Notice', 'interconnection' ),
			'id'            => 'notice-1',
			'description'   => esc_html__( 'Add widgets here.', 'interconnection' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
	// optional widget area for navigation
	register_sidebar(
		array(
			'name'          => esc_html__( 'Top navigation', 'interconnection' ),
			'id'            => 'topnav-1',
			'description'   => esc_html__( 'Add widgets here.', 'interconnection' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span>',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'interconnection_widgets_init' );

/**
 * Special class to highlight active menu item
 */
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-parent', $classes) || in_array('current-menu-item', $classes) ) {
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    if ( ! is_single() ) {
        $more = sprintf( '... <a class="read-more" href="%1$s">%2$s</a>',
            get_permalink( get_the_ID() ),
            __( 'Read More', 'textdomain' )
        );
    }
 
    return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Enqueue scripts and styles.
 */
function interconnection_scripts() {
	wp_enqueue_style( 'interconnection-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'interconnection-style', 'rtl', 'replace' );

	wp_enqueue_script( 'interconnection-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'interconnection-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'interconnection_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Class (e.g. Credits) autoloader.
 */
require get_template_directory() . '/inc/classes/class-autoload.php';

/**
 * Custom Fields functions.
 */
require get_template_directory() . '/inc/fields.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Remove related posts from bottom of post entry content
 * jetpack.com/support/related-posts/customize-related-posts/
 */
function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
 
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_action( 'wp', 'jetpackme_remove_rp', 20 );

/**
 * Enable Gutenberg
 */
if ( function_exists( 'wpcom_vip_load_gutenberg' ) ) {
    wpcom_vip_load_gutenberg( true );
}

/**
 * Filter X-hacker output.
 */
add_filter( 'wp_headers', function( $headers ) {
    if ( isset( $headers['X-hacker'] ) ) {
        unset( $headers['X-hacker'] );
    }
    return $headers;
}, 999 );
