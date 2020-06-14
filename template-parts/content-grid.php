<?php
/**
 * Template part for displaying posts in a grid
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

?>

<article class="grid-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<header class="entry-header">
		<?php interconnection_post_thumbnail(); ?>
		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
	</header><!-- .entry-header -->

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			interconnection_posted_on();
			interconnection_posted_by();
			?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
