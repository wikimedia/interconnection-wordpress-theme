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

			$sticky = get_option('sticky_posts');
			$exclude_from_grid = array();
			if ( is_home() && !empty($sticky) && ! is_paged() ) :
				// use the last added sticky post - last in array
				$the_query = new WP_Query( array ('p' => $sticky[count($sticky)-1] ) );
				$exclude_from_grid = [ $sticky[count($sticky)-1] ];

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					get_template_part( 'template-parts/modules/featured', 'post' );
				
				endwhile;

				/* Restore original Post Data */
				wp_reset_postdata();
			endif;
			
			query_posts( array_merge( 
				array(
					'ignore_sticky_posts' => true,
					'post__not_in' => $exclude_from_grid ),
					// merge with global query
					$wp_query->query
				)
			);
			if ( have_posts() ) : ?>

				<div class="posts-grid">
					<?php
					/* Start the normal Loop */
					while ( have_posts() ) :
						the_post();
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
