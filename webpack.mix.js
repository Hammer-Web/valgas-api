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

mix.sass('resources/views/dashboard/assets/sass/main.scss', 'public/dashboard/assets/css/app.css')
    .sass('resources/views/dashboard/assets/sass/vendor.scss', 'public/dashboard/assets/css/vendor.css')

    .sass('resources/views/dashboard/assets/sass/pages/login-register.scss', 'public/dashboard/assets/css/login.css')
    .sass('resources/views/dashboard/assets/sass/pages/dashboard.scss', 'public/dashboard/assets/css/dashboard.css')

    .scripts([
        'resources/views/dashboard/assets/js/vendor.min.js'
    ], 'public/dashboard/assets/js/vendor.js')

    .scripts([
        'resources/views/dashboard/assets/js/main.js',
        'resources/views/dashboard/assets/js/select2.min.js'
    ], 'public/dashboard/assets/js/main.js')

    .scripts([
        'resources/views/dashboard/assets/js/charts.js'
    ], 'public/dashboard/assets/js/charts.js')

    .scripts([
        'resources/views/dashboard/assets/js/sweetalert2.min.js'
    ], 'public/dashboard/assets/js/sweetalert2.min.js')

    .scripts([
        'resources/views/dashboard/assets/js/jquery.dataTables.min.js'
    ], 'public/dashboard/assets/js/dataTables.js')

    .scripts([
        'resources/views/dashboard/assets/js/jquery.mask.js'
    ], 'public/dashboard/assets/js/jquery.mask.js')

    .scripts([
        'resources/views/dashboard/assets/js/login.js'
    ], 'public/dashboard/assets/js/login.js')

    .copyDirectory('resources/views/dashboard/assets/fonts', 'public/dashboard/assets/fonts')
    .copyDirectory('resources/views/dashboard/assets/img', 'public/dashboard/assets/img')
    .copyDirectory('resources/views/dashboard/assets/favicon', 'public/dashboard/assets/favicon')
    .copyDirectory('resources/views/ckeditor', 'public/ckeditor')

    .options({
        processCssUrls: false
    })

    .version()
;
