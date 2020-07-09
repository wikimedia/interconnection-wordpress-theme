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

<div id="site-photo-credits" class="photo-credits section" title="photo-credits" role="complementary">
	
	<div class="wrapper">
		<!-- ATTENTION: need to translate -->
		<h2>Photo credits</h2>
		<div class="photo-credits-wrapper">
			<?php
			foreach ( $images as $image_id ) {
				// data to pass on to template part
				set_query_var( 'image_id', $image_id );
				get_template_part( 'template-parts/images/credit' );
			}
			?>
		</div>
	</div>

</div>
