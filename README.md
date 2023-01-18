# Interconnection

Interconnection is a WordPress theme developed for the Wikimedia community blog, [Diff](https://diff.wikimedia.org). It was created by Hang Do Thi Duc and is based upon [_underscores.](https://underscores.me/) It was reviewed by the Brand Studio Team in July 2020. 

### Theme details
* Grid-based layout using featured image for large thumbnail.
* Support for a single "hero" article via WordPress' sticky post feature with excerpt (20 words)
* Table of content for pages (with anchor links)
* Single post view includes the option to show special notice at the bottom of the articles. 
 * Notice can be shown for specific tag or category when "widget visibility controls" is enabled in Jetpack
* Clean formatted media credits at the bottom of each page
  * Uses Fieldmanager plugin. Credits managed via custom fields in Media Library
* Call to Action widget area for area below content
* Two column grid footer (one column on mobile)
* Custom logo in header navigation
* Customizer options to set link and accent color. 
* Customizer option to hide site branding on small screens
* Optional use of Headroom.js to hide header when scrolling. 
* Support for following plugins: Co-Author Plus, wpDiscuz, Polylang, Jetpack Related Posts (more planned for future improvements)

---------------
#### Installation
* Clone this repo into your WordPress 'themes' directory
* Activate the theme
* Customize

## Theme development
Development occurs primarily within the [themes/interconnection](themes/interconnection/) folder.

Run `composer install` to enable the use of PHPCS for linting theme code.

Run `npm install` to enable the frontend asset build process. The theme currently requires Node v14; if you use [nvm](https://github.com/nvm-sh/nvm), you can run `nvm use` (or `nvm install v14`) in the theme directory to set the correct version.

Useful commands, all usable from within the theme directory:

 Command                   | Description
-------------------------- | --------------------------------------------------------
`npm run`                  | See a list of all available npm commands
`npm run compile`          | Meta-command to lint and compile the CSS, including RTL
`npm run compile:css`      | Build the sass files into a single CSS file
`npm run watch:css`        | Monitor sass files for changes and automatically rebuild
`npm run lint:scss`        | Check the sass code for errors
`npm run lint:js`          | Check the JS files for errors
`composer lint:php`        | Check theme PHP files for errors

