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

mix.copy('node_modules/easytimer.js/dist/easytimer.js', 'public/js/easytimer.min.js')

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/job_card.js', 'public/js/job_card.js')
    .js('resources/js/job_card_bill.js', 'public/js/job_card_bill.js')
    .js('resources/js/insurance_claim.js', 'public/js/insurance_claim.js')
    .js('resources/js/job_sales.js', 'public/js/job_sales.js')
    .js('resources/js/employee_hourly_rate.js', 'public/js/employee_hourly_rate.js')
   .sass('resources/sass/app.scss', 'public/css');
