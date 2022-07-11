const { series, parallel } = require("gulp");

// // Importing Tasks
const { scss } = require("./scss");
const { browsersync } = require("./browsersync");
const { minify } = require("./minify");
const { scripts } = require("./scripts");
const { watch } = require("./watch");

const { build, devbuild } = require("./createdist");

// Serves website on localhost and watch for changes
// Compiles SCSS, JS, Optimize Images, Create Sprite Images and SCSS
// Create a dev server using browserSync and serve it on localhost
// To change your proxy address edit gulpconfig.json
const serve = series(parallel(scss, scripts), browsersync, watch);

module.exports = {
  serve,
  build,
  devbuild,
  minify,
  scss,
  scripts,
};
