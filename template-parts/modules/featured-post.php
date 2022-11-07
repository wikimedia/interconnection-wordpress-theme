<?php
/**
 * Template part for displaying the featured post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

$permalink = get_permalink();

?>
<article class="featured-post grid-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="featured-post-image">
		<?php interconnection_featured_post_thumbnail(); ?>
	</div>

	<div class="featured-post-text">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( $permalink ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				interconnection_posted_on();
				interconnection_posted_by();
				?>
			</div><!-- .entry-meta -->
			<div class="post-excerpt">
				<p>
					<?php
					$limit   = 20;
					$excerpt = explode( ' ', get_the_excerpt(), $limit );

					if ( count( $excerpt ) >= $limit ) {
						array_pop( $excerpt );
						$excerpt = implode( ' ', $excerpt ) . '...';
					} else {
						$excerpt = implode( ' ', $excerpt );
					}

					$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );
					echo esc_html( wp_strip_all_tags( $excerpt ) );
					?>
				</p>
				<!-- ATTENTION: Needs translation -->
				<a href="<?php echo esc_url( $permalink ); ?>" rel="bookmark" class="btn btn-accent"><?php echo esc_html__( 'Read more', 'interconnection' ); ?></a>
			</div>
		<?php endif; ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
