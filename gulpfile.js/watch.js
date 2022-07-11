const { PATHS, watchFiles } = require("./gulpfile.config");

const { watch: gulpWatch, series } = require("gulp");

const { reloadBrowser } = require("./browsersync");

const { scss } = require("./scss");
const {
  transpileScripts,
  webpackScripts,
  vendorScripts,
} = require("./scripts");
// const unhandledError = require("cli-handle-unhandled");

function watchSCSS() {
  // Watches for SCSS file changes
  if (watchFiles.scss == true) {
    gulpWatch(
      [PATHS.src.scss + "/meta/**/*.scss"],
      series(scss, reloadBrowser)
    );
  }
}

function watchJS() {
  // Watches for JS file changes inside ./src
  if (watchFiles.js == true) {
    gulpWatch(
      PATHS.src.js + "/vendors/**/*.js",
      series(vendorScripts, reloadBrowser)
    );
    gulpWatch(
      PATHS.src.js + "/webpack/**/*.js",
      series(webpackScripts, reloadBrowser)
    );
    gulpWatch(
      PATHS.src.js + "/scripts/**/*.js",
      series(transpileScripts, reloadBrowser)
    );
  }
}

function watchAssetsFolder() {
  // Watches for CSS file changes inside ./assets
  if (watchFiles.assetsCss == true) {
    gulpWatch(PATHS.assets.css + "/**/*.css", series(reloadBrowser));
  }

  // Watches for JS file changes inside ./assets
  if (watchFiles.assetsJs == true) {
    gulpWatch(PATHS.assets.js + "/**/*.js", series(reloadBrowser));
  }
}

function watchPHP() {
  // Watches for PHP files changes
  if (watchFiles.php == true) {
    gulpWatch(
      "**/*.php",
      { ignored: ["./node_modules/**/*.php"] },
      series(reloadBrowser)
    );
  }
}

// Watches for changes in style.scss, _template_variables.scss, *js files and images within src folder
function watch() {
  watchSCSS();
  watchJS();
  watchAssetsFolder();
  watchPHP();
}

module.exports = { watch };
