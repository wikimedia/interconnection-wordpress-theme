/**
 * File editor.js.
 *
 * Core block modifications and styles.
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
