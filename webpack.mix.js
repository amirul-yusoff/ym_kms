let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 | 
 */

 /**
  * Default Bootstrap
  * app.js
  * 
  * 
  * Inspinia template 
  * inspinia.js jquery.slimscroll.min.js jquery.metisMenu.js style.css animate.css font-awesome.min.css jquery-ui.min.js, popper.min.js
  * node_modules/moment/min/moment-with-locales.min.js > need to copy to asset/resources and to the public folder, can't webpack
  * 
  * 
  * Datatable 
  * jquery.dataTables.min.css dataTables.dataTables.min.js jquery.dataTables.min.js
  * 
  * ChartJs Colour use
  * chartjs-plugin-colorschemes.min.js
  * 
  * Cannot be webpacked but is required
  * Cannot webpack toastr.js, seems like a bug that prevents it from being packed correctly
  * Cannot webpack jquery-ui.min.js, popper.min.js
  * 
  * BlueImp Gallery, is used to display pictures in a gallery
  * A

  */

mix.js([
   'resources/assets/js/app.js',
   'resources/assets/js/inspinia/inspinia.js',
   'resources/assets/js/inspinia/jquery.slimscroll.min.js',
   'resources/assets/js/inspinia/plugins/metisMenu/jquery.metisMenu.js',
   'vendor/harvesthq/chosen/chosen.jquery.min.js',
   'resources/assets/js/bootstrap-datetimepicker.min.js',
   'resources/assets/js/datatables/datatables.js',
   'node_modules/jszip/dist/jszip.min.js',
   'node_modules/pdfmake/build/pdfmake.min.js',
   'node_modules/pdfmake/build/vfs_fonts.js',
   'node_modules/chartjs-plugin-colorschemes/dist/chartjs-plugin-colorschemes.min.js',
], 'public/js')
.sass('resources/assets/sass/app.scss', 'public/css')
.styles([
      'vendor/harvesthq/chosen/chosen.min.css',
      'node_modules/font-awesome/css/font-awesome.min.css',
      'node_modules/inspinia/dist/css/style.css',
      'node_modules/inspinia/dist/css/animate.css',
      'resources/assets/css/datatables/datatables.css',
      'resources/assets/css/toastr.css',
      'resources/assets/css/inspinia/bootstrap-datetimepicker.css',
      'node_modules/blueimp-gallery/css/blueimp-gallery.css',
      'node_modules/dropzone/dist/dropzone.css',
  ], 'public/css/all.css');