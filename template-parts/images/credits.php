<?php
/**
 * Handles image credits section
 *
 * Source: Reaktiv
 *
 * @package Interconnection
 */

if ( empty( $images ) ) {
	return;
}

?>

<div class="photo-credits">
	
	<div class="wrapper">
		<?php
		foreach ( $images as $image_id ) {
			// data to pass on to template part
			set_query_var( 'image_id', $image_id );
			get_template_part( 'template-parts/images/credit' );
		}
		?>
	</div>

</div>
