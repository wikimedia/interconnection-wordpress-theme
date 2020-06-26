<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Interconnection
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="wrapper">
			<section class="error-404 not-found">
				<header class="page-header">
					<div class="not-found-face">
						<div class="eye">X</div> <div class="eye">X</div><br>
						<div class="mouth">O</div>
					</div>
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'interconnection' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'interconnection' ); ?></p>

						<?php
						get_search_form();
						?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div>
	</main><!-- #main -->

<?php
get_footer();
