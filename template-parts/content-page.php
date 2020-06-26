<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php interconnection_post_thumbnail(); ?>

	<div class="entry-content">
		<div class="main-entry-content">
			<?php the_content(); ?>
		</div>

		<?php
		$patternHeading = '/<h2 id="(.*?)">(.*?)<\/h2>/';
		preg_match_all($patternHeading, get_the_content(), $matches);
		$ids = $matches[1];
		$headings = $matches[2];
		?>

		<div class="toc">
			<!-- ATTENTION: needs translation -->
			<h5>Table of contents</h5>
			<ul>
			<?php foreach ($ids as $key => $value) {
				echo '<li><a href="#' . esc_html( $ids[$key]) . '">' . esc_html( $headings[$key] ) . '</a></li>';
			} ?>
			</ul>
		</div>

		<?php wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'interconnection' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'interconnection' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
