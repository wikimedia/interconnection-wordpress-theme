<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Interconnection
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );

			?>
			<div class="wrapper">

				<?php
				if ( class_exists( 'Jetpack_RelatedPosts' ) ) :
					?>
					<div class="jetpack-related-posts">
						<?php echo do_shortcode( '[jetpack-related-posts]' ); ?>
					</div>
					<?php
				else :
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( '', 'interconnection' ) . '</span> <span class="nav-title">← %title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( '', 'interconnection' ) . '</span> <span class="nav-title">%title →</span>',
						)
					);
				endif;
				?>
			</div>
			<?php
		endwhile; // End of the loop.
		?>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
