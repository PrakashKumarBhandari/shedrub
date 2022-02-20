const { src, dest, watch, series, parallel } = require("gulp");
const sass = require("gulp-sass");
const connect = require("gulp-connect-php");
const useref = require("gulp-useref");
const uglify = require("gulp-uglify");
const gulpIf = require("gulp-if");
const cssnano = require("gulp-cssnano");
const imagemin = require("gulp-imagemin");
const cache = require("gulp-cache");
const plumber = require("gulp-plumber");
const del = require("del");
const browserSync = require("browser-sync").create();

async function nodeSass() {
    return await src("app/scss/**/*.scss")
        .pipe(plumber())
        .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
        .pipe(dest("app/css"))
        .pipe(
            browserSync.reload({
                stream: true,
            })
        );
}

// concatinate and minified the js scripts file using 'useref' and 'uglify' plugin
async function optimizeProdFiles() {
    return await src("app/*.php")
        .pipe(useref())
        // Minifies only if it's a JavaScript file using 'gulpIf plugin'
        .pipe(gulpIf("*.js", uglify()))
        // Minifies only if it's a CSS file using 'cssnano' plugin
        .pipe(gulpIf("*.css", cssnano()))
        .pipe(dest("dist"));
}

// optimizing images
async function optimizeImages() {
    return await src("app/images/**/*.+(png|jpg|jpeg|gif|svg)")
        .pipe(
            cache(
                imagemin({
                    interlaced: true,
                    progressive: true,
                    optimizationLevel: 5,
                    svgoPlugins: [{ removeViewBox: true }],
                })
            )
        )
        .pipe(dest("dist/images"));
}

// copying fonts to dist
async function fonts() {
    return await src("app/fonts/**/*").pipe(dest("dist/fonts"));
}

// Cleaning up dist folder
async function cleanDist() {
    return await del.sync("dist/**/*");
}

// browser relaod with browserSync using .php file extension
function browserReload() {
    connect.server({ base: "./app", port: 80, keeplive: true }, function () {
        browserSync.init({
            proxy: "127.0.0.1:80",
            port: 4306,
            open: true,
            notify: false,
        });
    });
    watch("app/scss/**/*.scss", series(nodeSass));
    watch("app/images/**/*").on("change", browserSync.reload);
    watch("app/**/*.php").on("change", browserSync.reload);
    watch("app/js/**/*.js").on("change", browserSync.reload);
}

exports.build = series(
    cleanDist,
    parallel(optimizeProdFiles, optimizeImages, fonts, nodeSass)
);
exports.dev = series(browserReload);
