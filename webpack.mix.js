const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .js('resources/js/pedido.js', 'public/js')
    .css('resources/css/style.css', 'public/css')
    .css('resources/css/pages/login.css', 'public/css/pages')
    .css('resources/css/pages/top.css', 'public/css/pages')
    .css('resources/css/pages/home.css', 'public/css/pages')
    .css('resources/css/pages/produto.css', 'public/css/pages')
    .css('resources/css/pages/pedido.css', 'public/css/pages')
    .css('resources/css/pages/compras.css', 'public/css/pages')
    .version();
