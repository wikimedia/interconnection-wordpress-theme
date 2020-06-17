<?php
/**
 * Template part for displaying the featured post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

?>

<article class="featured-post grid-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="featured-post-image">
		<?php interconnection_featured_post_thumbnail(); ?>
	</div>

	<div class="featured-post-text">	
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				interconnection_posted_on();
				interconnection_posted_by();
				?>
			</div><!-- .entry-meta -->
			<div class="post-excerpt">
				<?php the_excerpt(); ?>
				<!-- ATTENTION: Needs translation -->
				<a href="<?php esc_url( get_permalink() ); ?>" rel="bookmark" class="btn btn-dark">Read more</a>
			</div>
		<?php endif; ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->