let mix = require('laravel-mix');

mix.combine([
    'js/popup.js',
    'js/coursesGrid.js',
], 'dist/app.js')
    .sass('sass/app.scss', 'dist')
    .sass('sass/admin.scss', 'dist');