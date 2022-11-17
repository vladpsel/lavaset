let mix = require('laravel-mix');

mix
    //Admin
    .copy('resources/assets/admin', 'public/dist/img')
    .sass('resources/sass/admin.sass', 'public/dist/css/admin.css')
    .js('resources/js/script.js', 'public/dist/js/script.js')
    .js('resources/js/app.js', 'public/dist/js/app.js').vue()
    // Public
    .copy('resources/assets/app/fonts', 'public/dist/fonts')
    .copy('resources/css/font.css', 'public/dist/css/font.css')
    .copy('resources/assets/app/img', 'public/dist/img')
    .sass('resources/sass/style.sass', 'public/dist/css/style.css')
    .setPublicPath('public');
