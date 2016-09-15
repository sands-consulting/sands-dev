var elixir = require('laravel-elixir');
require('laravel-elixir-livereload');

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
    mix.scripts([
        'bower_components/angular/angular.js',
        'bower_components/angular-ui-router/release/angular-ui-router.min.js',
        'bower_components/elasticsearch/elasticsearch.angular.min.js',
        'resources/scripts/kb.js',
    ], 'public/js/kb.js', './');
    mix.version(['css/login.css', 'css/app.css', 'js/app.js', 'js/kb.js']);
    mix.livereload();
});
