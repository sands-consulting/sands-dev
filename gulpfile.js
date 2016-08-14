var elixir = require('laravel-elixir');

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
    mix.sass('login.scss')
       .sass('build.scss');
    mix.styles([
        'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        'bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
        'public/css/build.css',
    ], 'public/css/app.css', './');
    mix.scripts([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
        'bower_components/datatables.net/js/jquery.dataTables.js',
        'bower_components/datatables.net-bs/js/dataTables.bootstrap.js',
        'bower_components/datatables.net-responsive/js/dataTables.responsive.js',
        'bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.js',
    ], 'public/js/app.js', './');
    mix.version(['css/login.css', 'css/app.css', 'js/app.js']);
});
