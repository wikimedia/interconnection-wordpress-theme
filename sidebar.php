<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

if ( ! is_active_sidebar( 'cta-1' ) && ! is_active_sidebar( 'cta-2' ) ) {
	return;
}

?>
<aside id="cta-container" >
	<?php
	if ( is_active_sidebar( 'cta-1' ) ) {
		?>
		<div id="cta" class="cta-section section">
			<div class="wrapper">
				<?php dynamic_sidebar( 'cta-1' ); ?>
			</div>
		</div>
		<?php
	}

	if ( is_active_sidebar( 'cta-2' ) ) {
		?>
		<div id="cta2" class="cta-section section">
			<div class="wrapper">
				<?php dynamic_sidebar( 'cta-2' ); ?>
			</div>
		</div>
		<?php
	}
	?>
</aside><!-- #cta-container -->
