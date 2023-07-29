const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .js('resources/js/components/streaml/app.js', 'public/js/vue/streaml')
    .postCss('resources/css/app.css', 'public/css', [
    ]);