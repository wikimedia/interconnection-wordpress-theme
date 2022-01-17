/**
 * File editor.js.
 *
 * Core block modifications and styles.
 *
 * NOTE: We are temporarily using the wp object in the browser to avoid having to setup
 * Webpack and npm to bundle block files since we are only adding two block styles
 * to the Group block. However, if we continue to develop more complex block solutions,
 * we would need to setup the theme to handle modern block development.
 */
wp.domReady( function() {
	const __ = wp.i18n.__;

	// Add styles to the Group block.
	wp.blocks.registerBlockStyle(
		'core/group',
		[
			{
				name: 'flex-2',
				label: __( '2-Column', 'interconnection' )
			},
			{
				name: 'flex-3',
				label: __( '3-Column', 'interconnection' )
			},
		]
	);
});
