<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::post('/login', 'LoginController@autenticar')->name('site.login');
Route::get('/login/{erro?}', 'LoginController@index')->name('site.login');

/**
 * @var $router Router
 */

/** Rotas Produtos */
$router->post('produto', [
    'uses' => 'ProdutoController@create'
])->name('produto.create');

$router->get('produtos', [
    'uses' => 'ProdutoController@listar'
])->name('produto.listar');

$router->get('produto/{produto_id}', [
    'uses' => 'ProdutoController@buscar'
])->name('produto.buscar');

/** Rotas Fornecedor */
$router->post('fornecedor', [
    'uses' => 'FornecedorController@create'
])->name('fornecedor.create');

$router->get('fornecedores', [
    'uses' => 'FornecedorController@listar'
])->name('fornecedor.listar');

$router->get('fornecedor/{fornecedor_id}', [
    'uses' => 'FornecedorController@buscar'
])->name('fornecedor.buscar');

/** Rotas Cliente */
$router->post('cliente', [
    'uses' => 'ClienteController@create'
])->name('cliente.create');

$router->get('clientes', [
    'uses' => 'ClienteController@listar'
])->name('cliente.listar');

$router->get('cliente/{cliente_id}', [
    'uses' => 'ClienteController@buscar'
])->name('cliente.buscar');

/** Rotas Estoque */
$router->post('cadastrarestoque', [
    'uses' => 'EstoqueController@create'
])->name('estoque.create');

$router->get('estoque', [
    'uses' => 'EstoqueController@listar'
])->name('estoque.listar');

$router->get('estoque/{produto_id}', [
    'uses' => 'EstoqueController@buscar'
])->name('estoque.buscar');


$router->post('pedido', [
    'uses' => 'PedidoController@store'
])->name('pedido.envia');

