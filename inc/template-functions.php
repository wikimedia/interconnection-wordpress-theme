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

/**
 * Use a linked user account's "description" when showing a guest author archive,
 * and fall back to the guest author's biography field.
 *
 * @param string $description Archive description to be displayed.
 * @return string Filtered archive description.
 */
function interconnection_cap_description( $description ) : string {
	// No action for non-authors, or authors with descriptions.
	if ( ! is_author() || ! empty( $description ) ) {
		return $description;
	}

	// Only process guest authors.
	$queried_object = get_queried_object();
	if ( $queried_object->type !== 'guest-author' ) {
		return $description;
	}

	// Look up linked user record, if present.
	$linked_user = get_user_by( 'login', $queried_object->linked_account );
	if ( ! empty( $linked_user ) ) {
		$description = get_the_author_meta( 'description', $linked_user->ID );
		if ( ! empty( $description ) ) {
			return $description;
		}
	}

	// Finally, try to read from CAP record and return the guest author bio field.
	$description = get_post_meta( $queried_object->ID, 'cap-description', true ) ?: '';
	if ( ! empty( $description ) ) {
		return $description;
	}

	return $description;
}
add_filter( 'get_the_archive_description', 'interconnection_cap_description' );


/**
 * Toggles Polylang Content duplication for the current user.
 *
 * This function updates the 'pll_duplicate_content' user meta to control content duplication
 * across languages in Polylang. The feature is controlled by the 'pll-duplicate' option,
 * and when enabled, it allows the content to be duplicated across different languages.
 *
 * It makes the link https://<environment>/wp-admin/post-new.php?post_type=post&from_post=<POST-ID>&new_lang=<LANG>&_wpnonce=<NONCE>
 * to create a new post in the language specified by the 'new_lang' parameter.
 *
 * See #879 Diff bug ticket for more details.
 */
/**
 * Toggles Polylang content duplication.
 *
 * Ensures that Polylang content duplication is enabled for posts and pages
 * if Polylang is active and the user is on the new post or edit post screen.
 */
function toggle_polylang_content_duplication() {
	// Exit earlier if Polylang is not active.
	if ( ! function_exists( 'pll_is_translated_post_type' ) ) {
		return;
	}

	// Also exit if the user isn't on the new post or edit post screen.
	$post_type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : '';
	if ( empty( $post_type ) || ! in_array( $post_type, [ 'post', 'page' ], true ) ) {
		return;
	}

	update_user_meta( get_current_user_id(), 'pll_duplicate_content', [ 'post' => true ] );
}
add_action( 'admin_init', 'toggle_polylang_content_duplication' );
