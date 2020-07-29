<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Interconnection
 */

if ( ! is_active_sidebar( 'cta-1' ) ) {
	return;
}
?>

<aside id="cta-section" class="section">
	<div id="cta" class="cta-container section">	
		<div class="wrapper">
			<?php dynamic_sidebar( 'cta-1' ); ?>
		</div>
	</div>
	<div id="cta2" class="cta-container section">	
		<div class="wrapper">
			<?php dynamic_sidebar( 'cta-2' ); ?>
		</div>
	</div>
</aside><!-- #secondary -->
