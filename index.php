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
			$ignoreSticky = (is_home() ? 1 : 0);
			$the_query = new WP_Query( array( 'ignore_sticky_posts' => $ignoreSticky ) );
			if ( $the_query->have_posts() ) : ?>

				<div class="posts-grid">
					<?php
					/* Start the Loop */
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
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
