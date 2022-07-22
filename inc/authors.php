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
            'href' => preg_replace( '/author\/cap-/', 'author/', $args['href'] ),
        ]
    );
}
