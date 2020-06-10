<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Interconnection
 */

use Interconnection\Credits;

// Automatically add credits to all content
$images = Credits::get_instance()->get_ids();
// data to pass on to template part
set_query_var( 'images', $images );
get_template_part( 'template-parts/images/credits' );

?>

	<footer id="colophon" class="site-footer">
		<div class="footer-content wrapper">
			<?php dynamic_sidebar( 'footer-1' ); ?> <!-- widget area -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
