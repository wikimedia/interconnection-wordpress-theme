<?php
/**
 * Interconnection functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! defined( 'INTERCONNECTION_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'INTERCONNECTION_VERSION', '1.1.0' );
}

if ( ! function_exists( 'interconnection_setup' ) ) {
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
			[
				'menu-1' => esc_html__( 'Primary', 'interconnection' ),
			]
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			]
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
			[
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => [ 'site-title' ], // Option to hide site title.
			]
		);

		// Add theme support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
	}
}
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
	// Widget area for footer used in footer.php.
	register_sidebar(
		[
			'name'          => esc_html__( 'Footer', 'interconnection' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here. They are the footer content.', 'interconnection' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		]
	);

	// Call to action widget.
	register_sidebar(
		[
			'name'          => esc_html__( 'Call to action 1', 'interconnection' ),
			'id'            => 'cta-1',
			'description'   => esc_html__( 'Add widgets here. They appear after the home page posts.', 'interconnection' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		]
	);

	// Another call to action widget.
	register_sidebar(
		[
			'name'          => esc_html__( 'Call to action 2', 'interconnection' ),
			'id'            => 'cta-2',
			'description'   => esc_html__( 'Add widgets here. They appear after the home page posts.', 'interconnection' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		]
	);

	// Special notice for single posts.
	register_sidebar(
		[
			'name'          => esc_html__( 'Special notice', 'interconnection' ),
			'id'            => 'notice-1',
			'description'   => esc_html__( 'Add widgets here. They appear at the end of the entry of a posts.', 'interconnection' ),
			'before_widget' => '<div id="special-notice" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		]
	);

	// Optional widget area for navigation.
	register_sidebar(
		[
			'name'          => esc_html__( 'Secondary navigation', 'interconnection' ),
			'id'            => 'topnav-1',
			'description'   => esc_html__( 'Add widgets here. They appear in the header.', 'interconnection' ),
			'before_widget' => '<div class="%2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span>',
			'after_title'   => '</span>',
		]
	);

	// Optional widget for adding context on archive pages.
	register_sidebar(
		[
			'name'          => esc_html__( 'Archive pages', 'interconnection' ),
			'id'            => 'archive-1',
			'description'   => esc_html__( 'Add widgets here. They appear on archive pages.', 'interconnection' ),
			'before_widget' => '<div id="archive-notice" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		]
	);
}
add_action( 'widgets_init', 'interconnection_widgets_init' );

/**
 * Special class to highlight active menu item.
 */

/**
 * Special class to highlight active menu item.
 *
 * @param array $classes Array of the CSS classes that are applied to the menu item's <li> element.
 * @return array
 */
function interconnection_special_nav_class( $classes ) {
	if ( in_array( 'current-menu-parent', $classes, true ) || in_array( 'current-menu-item', $classes, true ) ) {
		$classes[] = 'active ';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'interconnection_special_nav_class', 10 );

/**
 * Filter the excerpt length to 25 words.
 *
 * @return int (Maybe) modified excerpt length.
 */
function interconnection_custom_excerpt_length() {
	return 25;
}
add_filter( 'excerpt_length', 'interconnection_custom_excerpt_length', 999 );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function interconnection_excerpt_more( $more ) {
	if ( ! is_single() ) {
		$more = '...';
	}
	return $more;
}
add_filter( 'excerpt_more', 'interconnection_excerpt_more' );

/**
 * Enqueue scripts and styles.
 */
function interconnection_scripts() {
	wp_enqueue_style( 'interconnection-style', get_stylesheet_uri(), [], INTERCONNECTION_VERSION );
	wp_style_add_data( 'interconnection-style', 'rtl', 'replace' );

	wp_enqueue_script( 'interconnection-navigation', get_template_directory_uri() . '/js/navigation.js', [], INTERCONNECTION_VERSION, true );

	wp_register_script( 'interconnection-headroom-js', get_template_directory_uri() . '/js/headroom.min.js', [], 'v0.12.0', true );
	wp_enqueue_script( 'interconnection-header', get_template_directory_uri() . '/js/header.js', [ 'interconnection-headroom-js' ], INTERCONNECTION_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'interconnection_scripts' );

/**
 * Enqueues block editor scripts and styles.
 */
function interconnection_block_scripts() {
	wp_enqueue_script( 'interconnection-editor', get_template_directory_uri() . '/js/editor.js', [ 'wp-blocks', 'wp-dom' ], INTERCONNECTION_VERSION, true );
}
add_action( 'enqueue_block_editor_assets', 'interconnection_block_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Credits class.
 */
require get_template_directory() . '/inc/classes/class-credits.php';

/**
 * Custom Fields functions.
 */
require get_template_directory() . '/inc/fields/media.php';

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
 * Enable Gutenberg
 */
add_filter( 'use_block_editor_for_post', '__return_true' );

/**
 * Customize co-authors-plus functionality.
 */
require_once get_template_directory() . '/inc/authors.php';
\Interconnection\Authors\bootstrap();

/**
 * Enable editorial categories customizations.
 */
require_once get_template_directory() . '/inc/editorial-categories.php';
\Interconnection\Editorial_Categories\bootstrap();

/**
 * Filter X-hacker output.
 *
 * @param array $headers Associative array of headers to be sent.
 * @return array
 */
function interconnection_xhacker_output( $headers ) {
	if ( isset( $headers['X-hacker'] ) ) {
		unset( $headers['X-hacker'] );
	}

	return $headers;
}
add_filter( 'wp_headers', 'interconnection_xhacker_output', 999 );

/**
 * Make legacy widgets available in the Legacy Widget block.
 *
 * Filters the list of widget-type IDs that should **not** be offered by the Legacy Widget block.
 * Returning an empty array will make all widgets available.
 *
 * @param array $widgets An array of excluded widget-type IDs.
 * @return array
 */
function interconnection_unhide_legacy_widgets( $widgets ) {
	// We specifically omit the 'media_image' widget to make it available.
	$widgets = [
		'pages',
		'calendar',
		'archives',
		'media_audio',
		'media_gallery',
		'media_video',
		'search',
		'text',
		'categories',
		'recent-posts',
		'recent-comments',
		'rss',
		'tag_cloud',
		'custom_html',
		'block',
	];

	return $widgets;
}
add_filter( 'widget_types_to_hide_from_legacy_widget_block', 'interconnection_unhide_legacy_widgets' );

/**
 * Remove Jetpack Related Posts from the bottom of post content.
 *
 * We are removing the related posts from post content so
 * we can add it within the post template instead.
 */
function interconnection_remove_jetpack_related_posts() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		$jprp     = Jetpack_RelatedPosts::init();
		$callback = [ $jprp, 'filter_add_target_to_dom' ];

		remove_filter( 'the_content', $callback, 40 );
	}
}
add_action( 'wp', 'interconnection_remove_jetpack_related_posts', 20 );

/**
 * Change the post Publish button text to Submit for Review.
 */
function interconnection_change_publish_button() {
	global $pagenow;

	// Only run on post editor page.
	if ( isset( $pagenow ) && ! ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {
		return;
	}

	// Check for Contributor role.
	if ( in_array( 'contributor', wp_get_current_user()->roles, true ) ) {
		add_filter( 'gettext', 'interconnection_change_publish_button_php', 10 );
		add_action( 'admin_print_footer_scripts', 'interconnection_change_publish_button_js' );
	}
}
add_action( 'init', 'interconnection_change_publish_button' );

/**
 * Filters text with its translation.
 *
 * @param string $translation Translated text.
 *
 * @return string
 */
function interconnection_change_publish_button_php( $translation ) {
	if ( 'Publish' === $translation ) {
		return esc_html__( 'Submit for Review', 'interconnection' );
	}

	return $translation;
}

/**
 * Print script and data queued for the footer.
 */
function interconnection_change_publish_button_js() {
	// Check that wp.i18n has been defined.
	if ( wp_script_is( 'wp-i18n' ) ) {
		?>
		<script>
			wp.i18n.setLocaleData( {
				'Publish': [
					'Submit for Review',
					'interconnection'
				]
			} );
		</script>
		<?php
	}
}

// TODO: Revisit this function in order to prevent duplicate posts
// from showing alongside English posts. In the meantime, we are
// temporarily disabling his featured as requested by the client.
/**
 * Query English posts along selected language posts in archives.
 *
 * Query English and selected language posts when switching languages
 * so we can replace translated content in the loop. This allows
 * us to display English posts if the posts are not translated.
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 */
function interconnection_modify_polylang_query( $query ) {
	// Query English posts only.
	if ( function_exists( 'pll__' ) && ! is_admin() && ! is_singular() && $query->is_main_query() ) {
		$languages = pll_default_language() . ',' . pll_current_language();
		$query->set( 'lang', $languages );
	}
}
// phpcs:ignore Squiz.PHP.CommentedOutCode.Found -- See b2eadee
// add_action( 'pre_get_posts', 'interconnection_modify_polylang_query' );

/**
 * Remove the sticky post from the homepage loop.
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 */
function interconnection_remove_homepage_sticky_posts( $query ) {
	// Get the last added sticky post - last in array.
	$sticky            = get_option( 'sticky_posts' );
	$exclude_from_grid = is_array( $sticky ) ? array_pop( $sticky ) : '';

	if ( ! is_admin() && is_home() && $query->is_main_query() ) {
		$query->set( 'ignore_sticky_posts', true );

		if ( ! empty( $exclude_from_grid ) ) {
			$query->set( 'post__not_in', [ $exclude_from_grid ] );
		}
	}
}

add_action( 'pre_get_posts', 'interconnection_remove_homepage_sticky_posts' );
