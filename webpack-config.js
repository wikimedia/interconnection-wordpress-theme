// Require path.
const path = require( 'path' );

// Configuration object.
const config = {
	// Create the entry points.
	// One for frontend and one for the admin area.
	entry: './js/customizer.js',
	// Create the output files.
	// One for each of our entry points.
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: '.src/index.js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, '.' )
	},
	module: {
		rules: [
			{
				// Look for any .js files.
				test: /\.js$/,
				// Exclude the node_modules folder.
				exclude: /node_modules/,
				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			}
		]
	},
    resolve: {
        fallback: {
          "child_process": false,
          "fs": false,
          "os": false,
          "path": false,
        }
      }
}

// Export the config object.
module.exports = config;