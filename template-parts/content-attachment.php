<?php
/**
 * Template part for displaying attachment page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

$credit_info = Interconnection\Credits::get_image_credits( get_the_ID() );
$author      = $credit_info['author'] ?? '';
$license     = $credit_info['license'] ?? '';
$license_url = $credit_info['license_url'] ?? '';
$url         = $credit_info['url'];

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrapper">

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>

		<div class="entry-meta">
			<?php if ( ! empty( $author ) ) : ?>
				<p class="credit"><?php echo esc_html( $author ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $license ) ) : ?>
				<p class="credit-desc" >
					<?php if ( ! empty( $license_url ) ) : ?>
						<a href="<?php echo esc_url( $license_url ); ?>" target="_blank">
					<?php endif; ?>
							<?php echo esc_html( $license ); ?>
					<?php if ( ! empty( $license_url ) ) : ?>
						</a>
					<?php endif; ?></p>
			<?php endif; ?>
		</div>
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
