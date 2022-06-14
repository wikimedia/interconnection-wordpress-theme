<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

get_header();

?>
<main id="primary" class="site-main">
	<div class="wrapper">
		<?php
		$sticky            = get_option( 'sticky_posts' );
		$exclude_from_grid = $sticky ? array( $sticky[ count( $sticky ) - 1 ] ) : '';

		if ( is_home() && ! empty( $sticky ) && ! is_paged() ) :
			// Use the last added sticky post - last in array.
			$the_query         = new WP_Query( array( 'post__in' => $exclude_from_grid ) );
			$exclude_from_grid = array( $sticky[ count( $sticky ) - 1 ] );

			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				get_template_part( 'template-parts/modules/featured', 'post' );
			endwhile;

			// Restore original post data.
			wp_reset_postdata();
		endif;

		query_posts(
			array_merge(
				array(
					'post__not_in' => $exclude_from_grid,
				),
				// Merge with global query.
				$wp_query->query
			)
		);

		if ( have_posts() ) :
			?>
			<div class="posts-grid">
				<?php
				// Start the normal loop.
				while ( have_posts() ) :
					the_post();

					if ( pll_get_post( get_the_ID() ) && get_the_ID() !== pll_get_post( get_the_ID() ) ) {
						// Do not display other languages posts if a translation in the current language exists.
						continue;
					}

					get_template_part( 'template-parts/content', 'grid' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_navigation();
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</div>
</main><!-- #main -->
<?php

get_sidebar();
get_footer();
