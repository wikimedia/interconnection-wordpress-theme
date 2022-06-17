<?php
/**
 * Control which categories are selectable in the admin depending on role.
 * See humanmade/Wikimedia#325
 */

namespace Interconnection\Editorial_Categories;

use WP_REST_Request;

const CACHE_KEY = 'interconnection_menu_categories';

/**
 * Connect namespace functions to actions or hooks.
 */
function bootstrap() : void {
    add_action( 'rest_category_query', __NAMESPACE__ . '\\limit_rest_categories_in_editor', 10, 2 );
    add_action( 'wp_update_nav_menu', __NAMESPACE__ . '\\invalidate_menu_categories_cache' );
}

/**
 * Get a list of the menu categories, and cache it.
 */
function get_navigation_category_ids() : array {
    $category_ids = wp_cache_get( CACHE_KEY );
    if ( $category_ids !== false ) {
        return $category_ids;
    }

    $menu_locations = get_nav_menu_locations();
    $primary_menu   = $menu_locations['menu-1'] ?? null;
    if ( empty( $primary_menu ) ) {
        return [];
    }

    $menu_items = wp_get_nav_menu_items( $primary_menu );
    if ( ! is_array( $menu_items ) ) {
        return [];
    }

    $category_ids = array_map(
        function( $menu_item ) {
            return $menu_item->object_id;
        },
        array_filter(
            $menu_items,
            function( $menu_item ) : bool {
                return ( $menu_item->type ?? '' ) === 'taxonomy' && ( $menu_item->type_label ?? '' ) === 'Category';
            }
        )
    );

    wp_cache_set( CACHE_KEY, $category_ids );

    return $category_ids;
}

/**
 * If an edit-context request is coming in which is authenticated as a contributor,
 * limit returned categories to those which appear in the navigation.
 *
 * @param array           $prepared_args Array of arguments for get_terms().
 * @param WP_REST_Request $request       The REST API request.
 * @return array Filtered get_terms() arguments.
 */
function limit_rest_categories_in_editor( array $prepared_args, WP_REST_Request $request ) : array {
    // The block editor sets per_page=100 to exhaustively enumerate categories.
    // We use that to only filter block editor-originated category requests.
    if ( ! is_user_logged_in() || ( $request->get_query_params()['per_page'] ?? 0 ) !== 100 ) {
        return $prepared_args;
    }

    $user_id    = get_current_user_id();
    $user_roles = get_userdata( $user_id )->roles ?? [];

    if ( is_super_admin( $user_id ) || in_array( 'administrator', $user_roles, true ) || in_array( 'editor', $user_roles, true ) ) {
        return $prepared_args;
    }

    $category_ids = get_navigation_category_ids();
    if ( ! empty( $category_ids ) ) {
        $prepared_args['include'] = $category_ids;
        $prepared_args['orderby'] = 'include';
    }

    return $prepared_args;
}

/**
 * Clear the cache for the editorially-significant menu items.
 */
function invalidate_menu_categories_cache() : void {
    wp_cache_delete( CACHE_KEY );
}
