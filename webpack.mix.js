let mix = require('laravel-mix');

mix
    .copy('resources/assets', 'public/dist/img')
    .sass('resources/sass/admin.sass', 'public/dist/css/admin.css')
    .js('resources/js/script.js', 'public/dist/js/script.js')
    .js('resources/js/app.js', 'public/dist/js/app.js').vue()
    .setPublicPath('public');
