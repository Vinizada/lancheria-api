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

// Rotas de autenticação, não protegidas pelo middleware
$router->post('/login', 'LoginController@autenticar')->name('site.autenticar');
$router->get('recuperarsenha', 'LoginController@recuperarSenha')->name('senha.recuperar');
$router->get('/login/{erro?}', 'LoginController@index')->name('site.login');
$router->get('/configuracoes', 'Configuracaocontroller@configuracoes')->name('app.configuracoes');
$router->get('/sair', 'LoginController@sair')->name('app.sair');

// Rotas protegidas pelo middleware de autenticação
Route::middleware(['auth:colaborador'])->group(function () use ($router) {
    $router->get('/home', 'HomeController@index')->name('app.home');

    /** Rotas Produtos */
    $router->get('cadastroproduto', 'ProdutoController@index')->name('produto.cadastro');
    $router->post('produto', 'ProdutoController@create')->name('produto.create');
    $router->get('produtos', 'ProdutoController@listar')->name('produto.listar');
    $router->get('produto/{produto_id}', 'ProdutoController@buscar')->name('produto.buscar');
    $router->get('produto/deletar/{produto_id}', 'ProdutoController@deletar')->name('produto.deletar');
    $router->get('produto/editar/{produto_id}', 'ProdutoController@editarProduto')->name('produto.editarProduto');
    $router->post('produto/editar', 'ProdutoController@editar')->name('produto.editar');
    $router->get('produto/imagem/{produto_id}', 'ProdutoController@imagem')->name('produto.imagem');

    /** Rotas Fornecedor */
    $router->get('cadastrofornecedor', 'FornecedorController@index')->name('fornecedor.cadastro');
    $router->post('fornecedor', 'FornecedorController@create')->name('fornecedor.create');
    $router->get('fornecedores', 'FornecedorController@listar')->name('fornecedor.listar');
    $router->get('fornecedor/{fornecedor_id}', 'FornecedorController@buscar')->name('fornecedor.buscar');
    $router->get('fornecedor/deletar/{fornecedor_id}', 'FornecedorController@deletar')->name('fornecedor.deletar');

    /** Rotas Cliente */
    $router->get('cadastrocliente', 'ClienteController@index')->name('cliente.cadastro');
    $router->post('cliente', 'ClienteController@create')->name('cliente.create');
    $router->get('clientes', 'ClienteController@listar')->name('cliente.listar');
    $router->get('cliente/{cliente_id}', 'ClienteController@buscar')->name('cliente.buscar');
    $router->get('cliente/deletar/{cliente_id}', 'ClienteController@deletar')->name('cliente.deletar');
    $router->post('cliente/editar', 'ClienteController@editar')->name('cliente.editar');

    /** Rotas Estoque */
    $router->get('cadastroestoque', 'EstoqueController@index')->name('estoque.cadastro');
    $router->post('cadastrarestoque', 'EstoqueController@create')->name('estoque.create');
    $router->get('estoque', 'EstoqueController@listarComprasProduto')->name('estoque.listarComprasProduto');
    $router->get('estoque/{produto_id}', 'EstoqueController@buscar')->name('estoque.buscar');
    $router->get('estoque/deletar/{produto_id}', 'EstoqueController@deletar')->name('estoque.deletar');

    /** Rotas Pedido */
    $router->post('pedido', 'PedidoController@create')->name('pedido.create');
    $router->get('pedido/buscar-produtos', 'PedidoController@buscarProdutos')->name('pedido.buscarProdutos');
    $router->get('pedido/{cliente_id}', 'PedidoController@index')->name('pedido.cadastro');
});
