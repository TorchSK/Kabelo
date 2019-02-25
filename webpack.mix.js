let mix = require('laravel-mix');

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

mix.less('resources/assets/less/copper/master.less','public/css/copper.css');
mix.less('resources/assets/less/dedra/master.less','public/css/dedra.css');

mix.copy('resources/assets/js/app.js','public/js/app.js',false);

