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
$img_url = wp_get_attachment_image_src( $image_id, 'thumbnail' )[0];
if ( empty( $attachment ) || ! $img_url ) {
	return;
}

$title       = $attachment->post_title;
$description = $attachment->post_content;

?>

<div class="photo-credit-container flex flex-all flex-wrap">
	<div class="img-container" style="background-image:url(<?php echo esc_url($img_url); ?>)">
	</div>
	<div class="text-container">
		<p><?php echo $title ?></p>
		<p><?php echo $description ?></p>
	</div>
</div>
