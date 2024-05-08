<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

// Ensure Polylang is up and running.
if ( function_exists( 'pll_the_languages' ) ) {
	// Retrieve the complete list of languages in raw format, including their translation status.
	$all_languages = pll_the_languages( [ 'raw' => 1 ] );
	// Initialize a new associative array to store languages which translation are miss.
	$languages_without_translations = [];

	// Loop throughout each language in the list.
	foreach ( $all_languages as $language ) {
		// If the 'no_translation' flag is set true for a specific language, this language miss translation.
		if ( $language['no_translation'] ) {
			// Add the untranslated language to the associative vector, mapping slug => name.
			$languages_without_translations[ $language['slug'] ] = $language['name'];
		}
	}
}

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
				<?php

				if ( is_singular() && ! empty( $languages_without_translations ) ) :
					?>
					<div class="translate-post-anchor">
						<a href="#translate-post"><?php echo esc_html__( 'Translate this post', 'interconnection' ); ?></a>
					</div>
					<?php
				endif;
			endif;
			?>
		</header><!-- .entry-header -->

		<?php interconnection_post_thumbnail(); ?>

		<div class="entry-content wrapper-small">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'interconnection' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				[
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'interconnection' ),
					'after'  => '</div>',
				]
			);

			if ( is_active_sidebar( 'notice-1' ) ) {
				dynamic_sidebar( 'notice-1' );
			}

			// If the current post is not translated in some language, displays the translation form.
			if ( ! empty( $languages_without_translations ) ) {
				?>
				<div  id="translate-post" class="translate-post">
					<div class="translate-post-image">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/translate-post.jpg'; ?>" alt="">
					</div>

					<div class="translate-post-content">
						<h2><?php echo esc_html__( 'Can you help us translate this article?', 'interconnection' ); ?></h2>

						<p><?php echo esc_html__( 'In order for this article to reach as many people as possible we would like your help. Can you translate this article to get the message out?', 'interconnection' ); ?></p>

						<?php
						if ( is_user_logged_in() ) {
							?>
							<fieldset>
								<form method="get" action="/wp-admin/post-new.php">
									<label for="new_lang"><?php echo esc_html__( 'Select Language', 'interconnection' ); ?></label>

									<input type="hidden" name="post_type" value="post">
									<input type="hidden" name="from_post" value="<?php the_ID(); ?>">

									<select name="new_lang" id="new_lang" class="pll-translation-select">
										<?php
										foreach ( $languages_without_translations as $key => $value ) {
											echo '<option value=' . esc_attr( $key ) . '>' . esc_html( $value ) . '</option>';
										}
										?>
									</select>

									<?php wp_nonce_field( 'new-post-translation', '_wpnonce', false ); // Match Polylang nonce action & name. ?>

									<input type="submit" value="<?php echo esc_attr__( 'Submit', 'interconnection' ); ?>">
								</form>
							</fieldset>
							<?php
						} else {
							$request_uri = rawurlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) . '#translate-post' ); // phpcs:ignore
							$return_url  = site_url( '/wp-login.php?redirect_to=' . $request_uri );

							?>
							<a href="<?php echo esc_url( $return_url ); ?>" class="translate-post-login"><?php echo esc_html__( 'Start translation', 'interconnection' ); ?></a>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}

			// Add Jetpack Related Posts.
			if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
				echo do_shortcode( '[jetpack-related-posts]' );
			}
			?>

		</div><!-- .entry-content -->
	</div>

	<footer class="entry-footer">
		<div class="wrapper flex flex-medium flex-space-between">
			<div class="comments-wrapper">
				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				} else {
					?>
					<!-- ATTENTION: need to translate -->
					<h3><?php echo esc_html__( 'No comments', 'interconnection' ); ?></h3>
					<p><?php echo esc_html__( 'Comments are closed automatically after 21 days.', 'interconnection' ); ?></p>
					<?php
				}
				?>
			</div>
			<div class="entry-footer-meta">
				<!-- ATTENTION: need to translate -->
				<h3><?php echo esc_html__( 'Meta', 'interconnection' ); ?></h3>
				<?php interconnection_entry_footer(); ?>
			</div>
		</div>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
