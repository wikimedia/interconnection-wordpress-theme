<?php
/**
 * Template part for displaying posts in a grid
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interconnection
 */

$lang_attribute = '';
$lang_title     = '';
$lang_slug      = pll_get_post_language( get_the_ID(), 'slug' );
$lang_name      = pll_get_post_language( get_the_ID(), 'name' );

if ( pll_current_language() !== $lang_slug ) {
	$lang_attribute = 'lang="' . $lang_slug . '"';
	$lang_title     = '<span aria-label="(' . $lang_name . ')">[' . strtoupper( $lang_slug ) . ']</span> ';
}

?>

<article class="grid-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo esc_attr( $lang_attribute ); ?>>
	<header class="entry-header">
		<?php interconnection_post_thumbnail(); ?>
		<?php echo esc_html( $lang_title ); ?>
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
