/**
 * File header.js.
 *
 * Handles the header position depending on user scrolling
 * Uses headroom.min.js
 */
 ( function() {
 	const header = document.querySelector("header");
 	const headroom = new Headroom(header);
	headroom.init();
 }() );