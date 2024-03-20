<?php
/**
 * Handles one image credit from image credits section
 *
 * Source: Reaktiv
 *
 * @package Interconnection
 */

if ( empty( $image_id ) ) {
	return;
}

$attachment = get_post( $image_id );
$img_url    = isset( wp_get_attachment_image_src( $image_id, 'thumbnail' )[0] ) ? wp_get_attachment_image_src( $image_id, 'thumbnail' )[0] : '';

if ( empty( $attachment ) || ! $img_url ) {
	return;
}

$credit_title = $attachment->post_title;
$description  = $attachment->post_content;
$credit_info  = Interconnection\Credits::get_image_credits( $image_id );
$author       = $credit_info['author'] ?? '';
$license      = $credit_info['license'] ?? '';
$license_url  = $credit_info['license_url'] ?? '';
$url          = $credit_info['url'];
?>

<div class="photo-credit-container flex flex-all flex-wrap">
	<div
		class="img-container"
		style="background-image:url(<?php echo esc_url( $img_url ); ?>)">
	</div>

	<div class="text-container">
		<p class="credit-desc">
			<?php if ( ! empty( $url ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>" target="_blank">
			<?php endif; ?>
					<?php echo esc_html( $credit_title ); ?>
			<?php if ( ! empty( $url ) ) : ?>
				</a>
			<?php endif; ?>
		</p>
		<?php if ( empty( $author ) && empty( $license ) ) : ?>
			<?php if ( ! empty( $description ) ) : ?>
				<p class="credit"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		<?php else : ?>

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
		<?php endif; ?>
	</div>
</div>
