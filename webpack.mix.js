const { mix } = require('laravel-mix');

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
   .options({
        postCss: [
            require('cssnano')({
                preset: ['default', {
                    discardComments: {
                        removeAll: true,
                    },
                }]
            }),
            require('autoprefixer')({
                browsers: '>0.1%'
            }),
        ]
   });