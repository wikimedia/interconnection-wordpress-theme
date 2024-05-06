<?php
/**
 * Integration with the co-authors-plus plugin.
 */

namespace Interconnection\Authors;

/**
 * Connect namespace functions to actions and hooks.
 */
function bootstrap() : void {
    add_filter( 'coauthors_posts_link', __NAMESPACE__ . '\\filter_co_authors_posts_link_args', 10, 2 );
    add_filter( 'pll_rel_hreflang_attributes', __NAMESPACE__ . '\\filter_polylang_href_rel_links' );
    add_action( 'template_redirect', __NAMESPACE__ . '\\redirect_author_if_old_cap_prefix' );
	add_action( 'save_post', __NAMESPACE__ . '\\update_post_author', 10, 2 );
}

/**
 * Remove `cap-` prefix from author slug in co-authors-plus URL.
 *
 * @param string $url CoAuthors Plus author archive permalink URL.
 * @return string URL without the `cap-` part.
 */
function de_cap_itate_author_url( string $url ) : string {
    return preg_replace( '/author\/cap-/', 'author/', $url );
}

/**
 * Filter the arguments used to render the co-authors-plus author link
 * to remove `cap-` prefix from co-authors-plus URLs.
 *
 * See humanmade/wikimedia#543 for related discussion.
 *
 * @param array  $args   Link arguments.
 * @param object $author CAP author object.
 * @return array Filtered args array.
 */
function filter_co_authors_posts_link_args( array $args, $author ) : array {
    if ( ! strpos( $args['href'], 'author/cap-' ) ) {
        return $args;
    }
    return array_merge(
        $args,
        [
            'href' => de_cap_itate_author_url( $args['href'] ),
        ]
    );
}

/**
 * Filter hreflang attributes displayed in the html head on frontend to remove
 * `cap-` prefix from co-authors-plus URLs.
 *
 * See humanmade/wikimedia#543 for related discussion.
 *
 * @param array $hreflangs Array of urls with language codes as keys and links as values
 * @return array Filtered hreflang attributes.
 */
function filter_polylang_href_rel_links( array $hreflangs ) : array {
    foreach ( $hreflangs as $lang => $href ) {
        $hreflangs[ $lang ] = de_cap_itate_author_url( $href );
    }
    return $hreflangs;
}

/**
 * Redirect from /author/cap-{author slug} to /author/{author slug} so that
 * only the pretty author URLs are exposed publicly.
 *
 * @see https://github.com/humanmade/wikimedia/issues/543
 *
 * @return void
 */
function redirect_author_if_old_cap_prefix() : void {
    if ( ! is_author() ) {
        return;
    }

    global $wp;
    preg_match( '#author/cap-([^/]+)#i', $wp->request, $cap_prefixed_author );

    if ( ! $cap_prefixed_author ) {
        // Author name does not match the specified pattern. Proceed.
        return;
    }

    $author_slug = $cap_prefixed_author[1];

    nocache_headers();

    // Redirect to the version of the URL with the "cap-" prefix removed.
    $redirect_url = str_replace( "cap-$author_slug", $author_slug, $wp->request );
    $redirect_url = preg_replace( '#^/?#', '/', $redirect_url );
    wp_safe_redirect( $redirect_url, 301 );
    exit();
}

/**
 * Given a list of coauthor records, return the first available User profile ID
 * that we can access from the coauthor linked accounts.
 *
 * @param array $coauthors Array of coauthor objects.
 * @return ?int ID of linked user account, or null if none found.
 */
function get_coauthor_user_id( array $coauthors ) : ?int {
	foreach ( $coauthors as $coauthor ) {
		$author_login = str_replace( 'cap-', '', $coauthor->linked_account ?? '' );
		$author_id    = get_user_by( 'login', $author_login )->ID ?? null;

		if ( ! empty( $author_id ) ) {
			return $author_id;
		}
	}

	return null;
}

/**
 * Update post_author with the first co-author plus assigned author.
 *
 * @param int     $post_id The post ID.
 * @param WP_Post $post    The post object.
 */
function update_post_author( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || ! function_exists( 'get_coauthors' ) ) {
		return;
	}

	$author_id = get_coauthor_user_id( get_coauthors( $post_id ) );

	if ( empty( $author_id ) ) {
		return;
	}

	// Unhook this function so it doesn't loop infinitely.
	remove_action( 'save_post', __NAMESPACE__ . '\\update_post_author' );

	// Update post author.
	wp_update_post( [
		'ID'          => $post_id,
		'post_author' => $author_id,
	] );

	// Re-hook this function.
	add_action( 'save_post', __NAMESPACE__ . '\\update_post_author' );
}
