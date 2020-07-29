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
    // Link color
    $wp_customize->add_setting( 'link_color', array(
    	'type' => 'theme_mod',
		'default'   => '#3366cc',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Link color', 'theme' ),
		'description' => esc_html__( 'Does not affect header or footer, among others', 'theme' ),
    ) ) );

    // Link underline (entry content)
    $wp_customize->add_setting( 'link_underline', array(
    	'type' => 'theme_mod',
		'default'   => false,
		'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'link_underline', array(
    	'type'    => 'checkbox',
		'section' => 'colors',
		'label'   => esc_html__( 'Link underline', 'theme' ),
		'description' => esc_html__( 'Add underline to links in entry content', 'theme' ),
    ) );

    // Accent button background color
    $wp_customize->add_setting( 'accent_color', array(
		'type' => 'theme_mod',
		'default'   => '#3366cc',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Accent color', 'theme' ),
		'description' => esc_html__( 'E.g. accent button color', 'theme' ),
    ) ) );

    // Accent button hover color
    $wp_customize->add_setting( 'accent_dark_color', array(
		'type' => 'theme_mod',
		'default'   => '#2a4b8d',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_dark_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Accent color dark', 'theme' ),
		'description' => esc_html__( 'E.g. accent button hover color', 'theme' ),
    ) ) );

    // CTA background
    $wp_customize->add_setting( 'accent_light_color', array(
		'type' => 'theme_mod',
		'default'   => '#eaf3ff',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_light_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Accent color light', 'theme' ),
		'description' => esc_html__( 'E.g. Call to action background', 'theme' ),
    ) ) );
}
add_action( 'customize_register', 'interconnection_customize_style' );

function interconnection_customize_style_css() {
	ob_start();

	$link_color = get_theme_mod( 'link_color', '' );
	$accent_color = get_theme_mod( 'accent_color', '' );
	$accent_dark_color = get_theme_mod( 'accent_dark_color', '' );
	$accent_light_color = get_theme_mod( 'accent_light_color', '' );
	$link_underline = get_theme_mod( 'link_underline', '') ? 'underline' : 'none';
	?>

	a, a:hover { 
		color: <?php echo $link_color; ?>; border-bottom-color: <?php echo $link_color; ?>; 
	}
	.btn-accent { 
		background: <?php echo $accent_color; ?>; 
	}
	.btn-accent:hover { 
		background: <?php echo $accent_dark_color; ?>; 
	}
	#cta { 
		background-color: <?php echo $accent_light_color; ?>; 
	}
	.entry-content a { 
		text-decoration: <?php echo $link_underline; ?>; 
	}
	
	<?php
	
	$css = ob_get_clean();
	return $css;
}

// Modify our styles registration like so:
function theme_enqueue_styles() {
  wp_enqueue_style( 'theme-styles', get_stylesheet_uri() );
  $custom_css = interconnection_customize_style_css();
  wp_add_inline_style( 'theme-styles', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );