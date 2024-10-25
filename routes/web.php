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


/**
 * @var $router Router
 */

$router->post('/login', 'LoginController@autenticar')->name('site.login');
$router->get('/login/{erro?}', 'LoginController@index')->name('site.login');
$router->get('/home', 'HomeController@index')->name('app.home');
$router->get('/sair', 'LoginController@sair')->name('app.sair');

/** Rotas Produtos */

$router->get('cadastroproduto', [
    'uses' => 'ProdutoController@index'
])->name('produto.cadastro');

$router->post('produto', [
    'uses' => 'ProdutoController@create'
])->name('produto.create');

$router->get('produtos', [
    'uses' => 'ProdutoController@listar'
])->name('produto.listar');

$router->get('produto/{produto_id}', [
    'uses' => 'ProdutoController@buscar'
])->name('produto.buscar');

$router->get('produto/deletar/{produto_id}', [
    'uses' => 'ProdutoController@deletar'
])->name('produto.deletar');

$router->get('produto/editar/{produto_id}', [
    'uses' => 'ProdutoController@editarProduto'
])->name('produto.editarProduto');

$router->post('produto/editar', [
    'uses' => 'ProdutoController@editar'
])->name('produto.editar');

$router->get('produto/imagem/{produto_id}', [
    'uses' => 'ProdutoController@imagem'
])->name('produto.imagem');

/** Rotas Fornecedor */
$router->get('cadastrofornecedor', [
    'uses' => 'FornecedorController@index'
])->name('fornecedor.cadastro');

$router->post('fornecedor', [
    'uses' => 'FornecedorController@create'
])->name('fornecedor.create');

$router->get('fornecedores', [
    'uses' => 'FornecedorController@listar'
])->name('fornecedor.listar');

$router->get('fornecedor/{fornecedor_id}', [
    'uses' => 'FornecedorController@buscar'
])->name('fornecedor.buscar');

$router->get('fornecedor/deletar/{fornecedor_id}', [
    'uses' => 'FornecedorController@deletar'
])->name('fornecedor.deletar');

/** Rotas Cliente */
$router->get('cadastrocliente', [
    'uses' => 'ClienteController@index'
])->name('cliente.cadastro');

$router->post('cliente', [
    'uses' => 'ClienteController@create'
])->name('cliente.create');

$router->get('clientes', [
    'uses' => 'ClienteController@listar'
])->name('cliente.listar');

$router->get('cliente/{cliente_id}', [
    'uses' => 'ClienteController@buscar'
])->name('cliente.buscar');

$router->get('cliente/deletar/{cliente_id}', [
    'uses' => 'ClienteController@deletar'
])->name('cliente.deletar');

$router->post('cliente/editar', [
    'uses' => 'ClienteController@editar'
])->name('cliente.editar');

/** Rotas Estoque */
$router->get('cadastroestoque', [
    'uses' => 'EstoqueController@index'
])->name('estoque.cadastro');

$router->post('cadastrarestoque', [
    'uses' => 'EstoqueController@create'
])->name('estoque.create');

$router->get('estoque', [
    'uses' => 'EstoqueController@listarComprasProduto'
])->name('estoque.listarComprasProduto');

$router->get('estoque/{produto_id}', [
    'uses' => 'EstoqueController@buscar'
])->name('estoque.buscar');

$router->get('estoque/deletar/{produto_id}', [
    'uses' => 'EstoqueController@deletar'
])->name('estoque.deletar');


$router->post('pedido', [
    'uses' => 'PedidoController@create'
])->name('pedido.create');

$router->get('pedido', [
    'uses' => 'PedidoController@index'
])->name('pedido.cadastro');

$router->get('pedido/buscar-produtos', [
    'uses' => 'PedidoController@buscarProdutos'
])->name('pedido.buscarProdutos');

