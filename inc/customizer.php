<?php
/**
 * Interconnection Theme Customizer
 *
 * @package Interconnection
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function interconnection_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'interconnection_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'interconnection_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'interconnection_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function interconnection_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function interconnection_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function interconnection_customize_preview_js() {
	wp_enqueue_script( 'interconnection-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'interconnection_customize_preview_js' );

/**
 * Theme style customization
 */
function interconnection_customize_style( $wp_customize ) {
	$wp_customize->add_section( 'interconnection_section' , array(
		'title' => __( 'Interconnection customizations', 'mytheme' ),
		'description' => esc_html__( 'This theme uses colors defined at design.wikimedia.org/style-guide/visual-style_colors by default.', 'theme' ),
		'priority' => 30,
	) );

    // Link color
    $wp_customize->add_setting( 'link_color', array(
    	'type' => 'theme_mod',
		'default' => '#3366cc',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Link color', 'theme' ),
		'description' => esc_html__( 'Does not affect header or footer, among others', 'theme' ),
    ) ) );

    // Link color
    $wp_customize->add_setting( 'visited_link_color', array(
    	'type' => 'theme_mod',
		'default' => '#6633cc',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'visited_link_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Visited link color', 'theme' ),
		'description' => esc_html__( 'Does not affect header or footer, among others', 'theme' ),
    ) ) );

    // Accent button background color
    $wp_customize->add_setting( 'accent_color', array(
		'type' => 'theme_mod',
		'default' => '#3366cc',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Accent color', 'theme' ),
		'description' => esc_html__( 'E.g. accent button color', 'theme' ),
    ) ) );

    // Accent button hover color
    $wp_customize->add_setting( 'accent_dark_color', array(
		'type' => 'theme_mod',
		'default' => '#2a4b8d',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_dark_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Accent color dark', 'theme' ),
		'description' => esc_html__( 'E.g. accent button hover color', 'theme' ),
    ) ) );

    // CTA background
    $wp_customize->add_setting( 'accent_light_color', array(
		'type' => 'theme_mod',
		'default' => '#eaf3ff',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_light_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Accent color light', 'theme' ),
		'description' => esc_html__( 'E.g. Call to action (2 column) background', 'theme' ),
    ) ) );

    // CTA 2 background
    $wp_customize->add_setting( 'neutral_background_color', array(
		'type' => 'theme_mod',
		'default' => '#eaecf0',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'neutral_background_color', array(
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Neutral highlight color', 'theme' ),
		'description' => esc_html__( 'E.g. Call to action (3 column) background', 'theme' ),
    ) ) );

    // Hide site-branding on smaller screen
    $wp_customize->add_setting( 'hide_site_branding', array(
    	'type' => 'theme_mod',
		'default' => false,
		'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'hide_site_branding', array(
    	'type' => 'checkbox',
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Site branding', 'theme' ),
		'description' => esc_html__( 'Hide site branding on small screens', 'theme' ),
    ) );
}
add_action( 'customize_register', 'interconnection_customize_style' );

function interconnection_customize_style_css() {
	ob_start();

	$link_color = get_theme_mod( 'link_color', '' );
	$accent_color = get_theme_mod( 'accent_color', '' );
	$visited_link_color = get_theme_mod( 'visited_link_color', '' );
	$accent_dark_color = get_theme_mod( 'accent_dark_color', '' );
	$accent_light_color = get_theme_mod( 'accent_light_color', '' );
	$neutral_background_color = get_theme_mod( 'neutral_background_color', '' );
	$hide_site_branding = get_theme_mod( 'hide_site_branding', '') ? 'none' : 'block';
	?>

	a, a:hover {
		color: <?php echo esc_attr( $link_color ); ?>; border-bottom-color: <?php echo esc_attr( $link_color ); ?>;
	}
	a:visited {
		color: <?php echo esc_attr( $visited_link_color ); ?>;
	}
	.btn-accent {
		background: <?php echo esc_attr( $accent_color ); ?>;
	}
	.btn-accent:hover {
		background: <?php echo esc_attr( $accent_dark_color ); ?>;
	}
	#cta {
		background-color: <?php echo esc_attr( $accent_light_color ); ?>;
	}
	#cta2 .widget {
		background-color: <?php echo esc_attr( $neutral_background_color ); ?>;
	}

	@media screen and (max-width: 500px) {
		.site-branding {
			display: <?php echo esc_attr( $hide_site_branding ); ?>;
		}
	}

	<?php

	$css = ob_get_clean();
	return $css;
}

// Modify our styles registration
function theme_enqueue_styles() {
	// handle defined in functions.php
	wp_enqueue_style( 'interconnection-style', get_stylesheet_uri() );
	$custom_css = interconnection_customize_style_css();
	wp_add_inline_style( 'interconnection-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Theme function customization
 */
function interconnection_customize_options( $wp_customize ) {
    // Enable headroom.min.js
    $wp_customize->add_setting( 'enable_headroom', array(
    	'type' => 'theme_mod',
		'default' => false,
		'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'enable_headroom', array(
    	'type' => 'checkbox',
		'section' => 'interconnection_section',
		'label' => esc_html__( 'Headroom.js', 'theme' ),
		'description' => esc_html__( 'Hide header when scrolling down', 'theme' ),
    ) );
}
add_action( 'customize_register', 'interconnection_customize_options' );

function theme_enqueue_scripts () {
	if ( !get_theme_mod( 'enable_headroom', '' ) ) {
		wp_deregister_script( 'interconnection-headroom-js' );
		wp_deregister_script( 'interconnection-header' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
