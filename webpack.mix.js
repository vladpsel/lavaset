let mix = require('laravel-mix');

mix
    // .options({
    //     vue: {
    //         compilerOptions: {
    //             preserveWhitespace: false,
    //         }
    //     }
    // })
    .copy('resources/assets', 'public/dist/img')
    .sass('resources/sass/admin.sass', 'public/dist/css/admin.css')
    .js('resources/js/app.js', 'public/dist/js/app.js').vue()
    .setPublicPath('public');
