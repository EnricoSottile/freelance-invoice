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

mix.js('resources/js/app.js', 'public/js');

mix.webpackConfig({
    resolve: {
      extensions: ['.js', '.vue', '.json'],
      alias: {
        // 'vue$': 'vue/dist/vue.esm.js',
        '@classes': __dirname + '/resources/js/classes',
        '@mixins': __dirname + '/resources/js/mixins',
        '@components': __dirname + '/resources/js/components',
        '@helpers': __dirname + '/resources/js/helpers'
      },
    },
  })




mix.postCss('resources/css/main.css', 'public/css', [
    require('tailwindcss'),
])