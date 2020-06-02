<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="wrapper">
	<header class="entry-header wrapper-small">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				interconnection_posted_on();
				interconnection_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php interconnection_post_thumbnail(); ?>

 	<div class="entry-content wrapper-small">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'interconnection' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'interconnection' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	</div>

 	<footer class="entry-footer">
 		<div class="wrapper flex flex-medium flex-space-between">
	 		<div class="comments-wrapper">
				<?php if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif; ?>
			</div>
			<div class="entry-footer-meta">
				<!-- ATTENTION: need to translate -->
				<h3>Meta</h3>
				<?php interconnection_entry_footer(); ?>
			</div>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
