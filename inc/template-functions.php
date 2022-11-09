<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Interconnection
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function interconnection_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'interconnection_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function interconnection_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'interconnection_pingback_header' );

/**
 * Output user description after author name.
 *
 * @param array  $link_args Co-Authors Plus link args object.
 * @param object $author    Author object.
 * @return array Filtered link args.
 */
function interconnection_show_author_description_in_byline( $link_args, $author ) {
	if ( ! isset( $author->type ) ) {
		return $link_args;
	}

	if ( is_admin() || ! is_single() ) {
		return $link_args;
	}

	if ( ! empty( $author->description ) ) {
		$link_args['after_html'] = sprintf( ', %s', $author->description );
	}

	return $link_args;
}
add_filter( 'coauthors_posts_link', 'interconnection_show_author_description_in_byline', 10, 2 );
