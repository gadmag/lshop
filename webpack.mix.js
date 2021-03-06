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

mix.js('resources/js/app.js', 'public/js/')
    .less('resources/less/app.less', 'public/css/')
    .sass('resources/sass/bootstrap.scss', 'public/css/')
    .styles([
        "public/css/fontawesome.css",
        "resources/css/preload.css",
        "resources/css/nprogress.css",
        "public/css/bootstrap.css",
        "public/css/bootstrap-ui.css",
    ], 'public/css/all.css');
mix.sass('resources/sass/bootstrap-ui.scss', 'public/css');
mix.scripts([
    'resources/js/lshop.js'
], 'public/js/all.js');
mix.js('resources/js/app-admin.js', 'public/AdminLTE/js');
mix.sass('resources/sass/jquery.nestable.scss', 'public/AdminLTE/css');
mix.version(['public/css/all.css', 'public/css/app.css', 'public/css/colorbox.css', 'public/js/all.js', 'public/js/jquery.colorbox.js']);
