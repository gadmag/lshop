var elixir = require('laravel-elixir');
 require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.sass('app.scss');

    mix.less('app.less')
        .webpack('app.js');
    mix.styles([
        'libs/bootstrap.min.css',
        'libs/select2.min.css',
        "libs/preload.css"
    ]);

    mix.scripts([
        'lshop.js'
    ]);



    mix.version(['css/all.css', 'css/app.css', 'css/colorbox.css', 'js/all.js', 'js/jquery.colorbox.js']);
});
