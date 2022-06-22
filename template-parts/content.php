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

			if ( is_active_sidebar( 'notice-1' ) ) {
				dynamic_sidebar( 'notice-1' );
			}

			if ( function_exists( 'pll_the_languages' ) ) {

				// Get all languages in raw output.
				$raw_languages = pll_the_languages( array( 'raw' => 1 ) );

				// Remove languages that have translations.
				foreach ( $raw_languages as $sub_key => $sub_array ) {
					if ( false === $sub_array['no_translation'] ) {
						unset( $raw_languages[ $sub_key ] );
					}
				}

				// Rename modified array.
				$no_translation = $raw_languages;

				// Create language slugs array.
				$language_slugs = array();
				foreach ( $no_translation as $key ) {
					$language_slugs[] = $key['slug'];
				}

				// Create language names array.
				$language_names = array();
				foreach ( $no_translation as $key ) {
					$language_names[] = $key['name'];
				}

				// Combine language slugs and names into new array.
				$languages = array_combine( $language_slugs, $language_names );

				if ( ! empty( $languages ) ) {
					?>
					<div  id="translate-post" class="translate-post">
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
										foreach ( $languages as $key => $value ) {
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
					<?php
				}
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
				};
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
