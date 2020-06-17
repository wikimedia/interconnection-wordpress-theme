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

				$related = Jetpack_RelatedPosts::init_raw()->get_for_post_id( get_the_ID(), array( 'size' => 3 ) );

				if ( $related ) {
					foreach ( $related as $result ) {
						$posts_id[] = $result[ 'id' ];
					}

					$the_query = new WP_Query( array(
						'post_type' => 'post',
						'post__in' => $posts_id
					) );

					if( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) { $the_query->the_post();
						// get_template_part( 'template-parts/similar-post' );
						echo 'title' . get_the_title();
						}
					}

					wp_reset_query();
				}
			?>

			<div class="wrapper">
				<?php echo do_shortcode( '[jetpack-related-posts]' ); ?>

				<?php if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) { ?>
					<div class="jetpack-related-posts">
						<?php 
							$related = Jetpack_RelatedPosts::init_raw()->get_for_post_id( get_the_ID(), array( 'size' => 3 ) );
							echo get_the_ID();
							var_dump($related);

							if ( $related ) {
								foreach ( $related as $result ) {
									$posts_id[] = $result[ 'id' ];
								}

								$the_query = new WP_Query( array(
									'post_type' => 'post',
									'post__in' => $posts_id
								) );

								if( $the_query->have_posts() ) {
								while ( $the_query->have_posts() ) { $the_query->the_post();
									// get_template_part( 'template-parts/similar-post' );
									echo get_the_title();
									}
								}

								wp_reset_query();
							}

						?>
					</div>
				<?php } else {
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( '', 'interconnection' ) . '</span> <span class="nav-title">← %title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( '', 'interconnection' ) . '</span> <span class="nav-title">%title →</span>',
						)
					);
				}; ?>
			</div>

			<?php endwhile; // End of the loop. 
			?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
