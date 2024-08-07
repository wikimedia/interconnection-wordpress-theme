<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'interconnection' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="top-nav wrapper flex flex-all flex-align-center">
			<?php the_custom_logo(); ?>
			<div class="site-branding">
				<h4 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h4>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" title="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"></button>
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					]
				);
				?>
			</nav><!-- #site-navigation -->
			<nav id="site-navigation-2" class="secondary-navigation" title="secondary-navigation">
				<?php
				if ( is_active_sidebar( 'topnav-1' ) ) {
					dynamic_sidebar( 'topnav-1' );}
				?>
			</nav><!-- #site-navigation-2 -->
		</div><!-- top-nav -->
	</header><!-- #masthead -->

	<div class="site-start wrapper">
		<?php if ( is_front_page() ) { ?>
			<p class="site-description"><?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?></p>
		<?php } ?>
	</div>

<?php
// Automatically add credits to all content
Interconnection\Credits::get_instance( get_the_ID() );
