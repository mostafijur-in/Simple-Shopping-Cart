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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sourceMaps();


// Custom styles
mix.styles('resources/assets/css/styles.css', 'public/css/styles.css');

// Custom scripts
mix.js('resources/assets/js/scripts.js', 'public/js/scripts.js')
    .js('resources/assets/js/admin-scripts.js', 'public/js/admin-scripts.js')
    .js('resources/assets/js/auth.js', 'public/js/auth.js');

// Copy images
mix.copyDirectory('resources/assets/img', 'public/images');

// NiceAdmin Bootstrap v5 Template assets for studentuser dashboard
// Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
mix.copyDirectory('resources/assets/niceadmin', 'public/niceadmin');
