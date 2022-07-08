const {
  MODE, // 'development' or 'production'
  COMPRESSION, // true | false : compresses css and js files while compiling them
  PATHS,
  JSBUILD,
} = require("./gulpfile.config");

const { src, dest, parallel } = require("gulp");
const rename = require("gulp-rename");
const plumber = require("gulp-plumber");
const gulpIf = require("gulp-if");
const concat = require("gulp-concat");

// JSBUILD:"webpack" modules
const named = require("vinyl-named");
const webpackCompiler = require("webpack");
const webpack = require("webpack-stream");
// Workaround for webpack.config.js for multicomplier support
const webpackConfig = require("./webpack.config");

// JSBUILD:"concat" modules
const babel = require("gulp-babel");
const terser = require("gulp-terser");
const gulpIgnore = require("gulp-ignore");

// const unhandledError = require("cli-handle-unhandled");

// Copies files from assets_src/js/vendors folder to assets/js
function vendorScripts() {
  return src(PATHS.src.js + "/vendors/*.js")
    .pipe(
      plumber({
        errorHandler: function (err) {
          console.log(err);
          this.emit("end");
        },
      })
    )
    .pipe(dest(PATHS.assets.js));
}

// Transpiles JS files from assets_src/js/scripts folder to assets/js
function transpileScripts() {
  return src(PATHS.src.js + "/scripts/*.js", {
    sourcemaps: true,
  })
    .pipe(
      plumber({
        errorHandler: function (err) {
          console.log(err);
          this.emit("end");
        },
      })
    )
    .pipe(babel({ presets: ["@babel/preset-env"] }))
    .pipe(dest(PATHS.assets.js, { sourcemaps: "./maps" }))
    .pipe(gulpIgnore.exclude((file) => /map?$/.test(file.path)))
    .pipe(
      gulpIf(
        COMPRESSION,
        terser({
          mangle: {
            toplevel: true,
          },
        })
      )
    )
    .pipe(gulpIf(COMPRESSION, rename({ suffix: ".min" })))
    .pipe(gulpIf(COMPRESSION, dest(PATHS.assets.js, { sourcemaps: "./maps" })));
}

// build /assets_src/js/webpack/index.js file via Webpack
function webpackScripts() {
  return src(PATHS.src.js + "/webpack/index.js")
    .pipe(named())
    .pipe(
      webpack(webpackConfig, webpackCompiler, function (err, stats) {
        console.log(err);
      })
    )
    .pipe(rename({ basename: "scripts.bundle", suffix: ".min" }))
    .pipe(dest(PATHS.assets.js));
}

const scripts = parallel(transpileScripts, webpackScripts, vendorScripts);

module.exports = { transpileScripts, webpackScripts, vendorScripts, scripts };
