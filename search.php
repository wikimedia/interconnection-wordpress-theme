<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Interconnection
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="wrapper">
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'interconnection' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->

				<div class="posts-grid">
					<?php
					/* Start the Loop */
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
