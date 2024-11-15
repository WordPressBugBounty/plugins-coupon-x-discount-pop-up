const mix = require('laravel-mix');
mix.sass('src/app.scss', 'assets/admin/css/');
mix.js('src/app.js', 'assets/admin/js/')