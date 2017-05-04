const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let assetsPath = 'resources/assets/';
let exportPath = 'public/';

mix.js([
    assetsPath + 'js/app.js',
    assetsPath + 'talvbansal/media-manager/js/media-manager.js',
], exportPath + 'js')
   .sass(assetsPath + 'sass/app.scss', exportPath + 'css').version();