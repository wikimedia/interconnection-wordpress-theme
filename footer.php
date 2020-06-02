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

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info wrapper">
			<p>
				<span class="site-title"><?php bloginfo( 'name' ); ?></span>
				<?php $interconnection_description = get_bloginfo( 'description', 'display' ); ?> –
				<span class="site-description"><?php echo $interconnection_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</p>
			<?php dynamic_sidebar( 'footer-1' ); ?> <!-- widget area -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
