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

mix
    .setPublicPath('public/assets')
    .setResourceRoot('../')
    .js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css')
    .less('resources/assets/less/adminlte.less','css')
    .combine([
        'public/assets/css/app.css',
        'node_modules/admin-lte/dist/css/skins/_all-skins.css',
        'public/assets/css/adminlte.css',
        'node_modules/icheck/skins/square/blue.css',
        'node_modules/sweetalert/dist/sweetalert.css',
        'node_modules/select2/dist/css/select2.css',
        'node_modules/jstree/dist/themes/default/style.min.css',
        'resources/assets/css/app.css'
    ], 'public/assets/css/app.css')
    .scripts([
        'public/assets/js/app.js',
        'node_modules/select2/dist/js/select2.full.js',
        'node_modules/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js'
    ], 'public/assets/js/app.js')
    .copy('resources/assets/img','public/assets/images')
    //VENDOR RESOURCES
    .copy('node_modules/jstree/dist/themes/default/throbber.gif', 'public/assets/css/throbber.gif')
    .copy('node_modules/jstree/dist/themes/default/40px.png', 'public/assets/css/40px.png')
    .copy('node_modules/jstree/dist/themes/default/32px.png', 'public/assets/css/32px.png')
    .copy('node_modules/icheck/skins/square/blue.png','public/assets/css')
    .copy('node_modules/icheck/skins/square/blue@2x.png','public/assets/css')
    .copy('node_modules/bootstrap-fileinput', 'public/vendor/bootstrap-fileinput')
    .copy('node_modules/ckeditor', 'public/vendor/ckeditor')
    .copy('node_modules/clipboard', 'public/vendor/clipboard')
    //datetime-picker
    .copy('node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css', 'public/vendor/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css')
    .copy('node_modules/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js', 'public/vendor/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js');
