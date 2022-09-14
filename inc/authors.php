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
