<?php
/**
 * Template part for displaying attachment page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrapper">

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>

		<div class="entry-content">
			<div class="main-entry-content">
				<?php
					$image_size = apply_filters( 'wporg_attachment_size', 'large' );
					echo wp_kses( wp_get_attachment_image( get_the_ID(), $image_size ), 'post' );
				?>
			</div>
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
