let mix = require('laravel-mix');
require('laravel-mix-purgecss');

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

// internal css
mix.less('resources/assets/less/dedra/master.less','public/css/dedra.css').purgeCss({enabled: true});

// external css
mix.styles('resources/assets/css/*','public/css/ext.css').purgeCss({enabled: true});

mix.babel(['resources/assets/js/app.js','resources/assets/js/ui.js','resources/assets/js/semantic.js'],'public/js/app.js');
mix.copy('resources/assets/js/admin.js','public/js/admin.js');
