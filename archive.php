<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="wrapper">
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					if ( is_active_sidebar( 'archive-1' ) ) {
						dynamic_sidebar( 'archive-1' );
					}
					?>
				</header><!-- .page-header -->

				<div class="posts-grid">
					<?php
					/* Start the Loop */
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
