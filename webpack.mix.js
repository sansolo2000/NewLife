const mix = require('laravel-mix');
const RESOURCE_PATH = `resources`;
const NODE_MODULES_PATH = `node_modules`;


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

/* mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

 */


mix
   .scripts(
      [
         `${NODE_MODULES_PATH}/jquery/dist/jquery.js`,  
         `${NODE_MODULES_PATH}/bootstrap/dist/js/bootstrap.js`, 
         `${NODE_MODULES_PATH}/gijgo/js/gijgo.js`,
         `${NODE_MODULES_PATH}/datatables/media/js/jquery.dataTables.js`,
         `${NODE_MODULES_PATH}/datatables.net-plugins/sorting/date-euro.js`,
         `${NODE_MODULES_PATH}/bs-custom-file-input/dist/bs-custom-file-input.js`,
         `${RESOURCE_PATH}/js/app.js`
      ], `public/js/app.js`)
   .styles(
      [
         `${NODE_MODULES_PATH}/gijgo/css/gijgo.css`,
         `${RESOURCE_PATH}/dist/css/adminlte.css`,
         `${NODE_MODULES_PATH}/datatables/media/css/jquery.dataTables.css`,
      ], `public/css/custom.css`)
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps()
   .copy(`${RESOURCE_PATH}/dist/js`, `public/dist/js`, false)
   .copy(`${RESOURCE_PATH}/dist/css`, `public/dist/css`, false)
   .copy(`${RESOURCE_PATH}/dist/img`, `public/dist/img`, false)
   .copy(`${NODE_MODULES_PATH}/datatables/media/images`, `public/images`, false)
   .copy(`${NODE_MODULES_PATH}/datatables.net-plugins/i18n/es_es.json`, `public/i18n`, false)
   .options({
      processCssUrls: false // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
    });