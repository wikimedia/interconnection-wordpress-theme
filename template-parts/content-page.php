<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
		// Use REGEX named captures to create indices for "id" and "content".
		$pattern_heading = '/<h2[^>]+id="(?<id>.*?)"[^>]*>(?<content>.*?)<\/h2>/';
		preg_match_all( $pattern_heading, get_the_content(), $matches );
		$ids      = $matches[ 'id' ];
		$headings = $matches[ 'content' ];
		?>

		<div class="toc">
			<!-- ATTENTION: needs translation -->
			<h5>Table of contents</h5>
			<ul>
			<?php
			foreach ( $ids as $key => $value ) {
				echo '<li><a href="' . esc_url( '#' . $ids[ $key ] ) . '">' . esc_html( $headings[ $key ] ) . '</a></li>';
			}
			?>
			</ul>
		</div>

		<?php
		wp_link_pages(
			[
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'interconnection' ),
				'after'  => '</div>',
			]
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
						[
							'span' => [
								'class' => [],
							],
						]
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
