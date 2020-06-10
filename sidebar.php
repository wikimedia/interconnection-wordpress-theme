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

<aside id="secondary" class="widget-area">
	<div class="wrapper">
		<?php dynamic_sidebar( 'cta-1' ); ?>
	</div>
</aside><!-- #secondary -->
