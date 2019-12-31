const mix = require('laravel-mix');

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

 mix.browserSync({
         proxy: 'http://budgets.test',
         open: false,
         browser:'Google chrome',
         ghostMode: false,
         watch:true,
     });

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/pdf.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css');
