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
		<h2><?php echo esc_html__( 'Photo credits', 'interconnection' ); ?></h2>
		<div class="photo-credits-wrapper">
			<?php
			foreach ( $images as $image_id ) {
				// Data to pass on to template part.
				set_query_var( 'image_id', $image_id );
				get_template_part( 'template-parts/images/credit' );
			}
			?>
		</div>
	</div>

</div>
