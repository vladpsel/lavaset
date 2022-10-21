let mix = require('laravel-mix');

mix
    // .js('src/app.js', 'dist')
    .copy('resources/assets', 'public/dist/img')
    .sass('resources/sass/admin.sass', 'public/dist/css/admin.css')
    .setPublicPath('public');
