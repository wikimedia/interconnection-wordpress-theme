<?php
/**
 * Integration with The Events Calendar plugin.
 */

namespace Interconnection\Events;

/**
 * Connect namespace functions to actions and hooks.
 */
function bootstrap() : void {
	add_filter( 'tribe_events_editor_default_template', __NAMESPACE__ . '\\filter_events_default_block_template', 11, 1 );
}

/**
 * Filter the default Events block template.
 *
 * This function adds the custom Event Language Selector block to the template.
 *
 * @param array $template Array with template blocks to be generated.
 * @return array Filtered template.
 */
function filter_events_default_block_template( array $template ) : array {
	$template = [
		[ 'tribe/event-datetime' ],
		[ 'core/paragraph', [
			'placeholder' => __( 'Add Description...', 'the-events-calendar' ),
		], ],
		[ 'tribe/event-price' ],
		[ 'tribe/event-organizer' ],
		[ 'tribe/event-venue' ],
		[ 'tribe/field-ecpcustom2' ], // Custom Registration Link field added under Events > Settings > Addition Fields.
		[ 'interconnection/event-language' ], // Custom Event Language Selector block.
		[ 'tribe/event-website' ],
		[ 'tribe/event-links' ],
	];

	return $template;
}
