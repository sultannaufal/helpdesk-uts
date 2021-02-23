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

mix.setPublicPath('public/build')
    .options({
        processCssUrls: false, // https://github.com/JeffreyWay/laravel-mix/issues/49#issuecomment-284256971
    })
    .setResourceRoot('/build/')
    .js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .version();
