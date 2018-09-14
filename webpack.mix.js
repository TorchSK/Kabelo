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

mix.less('resources/assets/less/layout1/master.less','public/css/app_layout_1.css');
mix.less('resources/assets/less/layout2/master.less','public/css/app_layout_2.css');


mix.copy('resources/assets/js/app.js','public/js/app.js',false);