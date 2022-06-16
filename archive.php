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

					global $post;

					// Get translated post in current language if it exists.
					if ( pll_get_post( get_the_ID() ) && get_the_ID() !== pll_get_post( get_the_ID() ) ) :
						// Overwrite global post data with the translated post content.
						$post = get_post( pll_get_post( get_the_ID() ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride

						// Sets up global post data for using with template tags.
						setup_postdata( $post );
					endif;

					get_template_part( 'template-parts/content', 'grid' );
				endwhile;

				// Restore original post data.
				wp_reset_postdata();
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
