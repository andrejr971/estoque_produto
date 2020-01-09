<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/adicionarPedido', function() {
    return redirect()->route('verEstoqueBaixo');
});

Route::post('/adicionarPedido', [
    'as' => 'addApiPedido',
    'uses' => 'ControladorPedidoEstoque@addPedido'
]);

Route::get('/pedidosAberto/{id}', [
    'as' => 'apiPedidos',
    'uses' => 'ControladorPedidoEstoque@indexApi'
]);

Route::get('/pedidosAberto', [
    'as' => 'apiPedidos2',
    'uses' => 'ControladorPedidoEstoque@indexApi2'
]);

Route::get('/enviarPedido/{id}', [
    'as' => 'enviarPedido',
    'uses' => 'ControladorPedidoEstoque@enviarPedido'
]);

/**Saida */
Route::get('/relSaida', [
    'as' => 'relSaida',
    'uses' => 'ContoladorEstoque@relSaida'
]);

Route::get('/filtrarEntrada/{data}', [
    'as' => 'filtrarEntrada',
    'uses' => 'ContoladorEstoque@filtrarEntrada'
]);

Route::get('/relComSaida', [
    'as' => 'relComSaida',
    'uses' => 'ContoladorEstoque@relComSaida'
]);

Route::get('/filtroRelatorioSaida/{id}', [
    'as' => 'filtroRelatorioSaida',
    'uses' => 'ContoladorEstoque@filtroRelatorioSaida'
]);

Route::get('/filtroRelatorioCatSaida/{id}/{opcao}', [
    'as' => 'filtroRelatorioCatSaida',
    'uses' => 'ContoladorEstoque@filtroRelatorioCatSaida'
]);

Route::get('/filtroRelatorioCategoriasSaida/{opcao}', [
    'as' => 'filtroRelatorioCategoriasSaida',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategoriasSaida'
]);

Route::get('/filtroRelatorioCategoriasMSaida/{id}/{mes}', [
    'as' => 'filtroRelatorioCategoriasMSaida',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategoriasMSaida'
]);

Route::get('/filtroRelatorioCategoriasMSaida/{id}/{mes}/{opcao}', [
    'as' => 'filtroRelatorioCategoriasMSaida',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategoriasMCatSaida'
]);

Route::get('/relSaidaMes', [
    'as' => 'relSaidaMes',
    'uses' => 'ContoladorEstoque@relSaidaMes'
]);

/**Entrada */
Route::get('/relEntrada', [
    'as' => 'relEntrada',
    'uses' => 'ContoladorEstoque@relEntrada'
]);

Route::get('/filtrarEntrada/{data}', [
    'as' => 'filtrarEntrada',
    'uses' => 'ContoladorEstoque@filtrarEntrada'
]);

Route::get('/relComEntrada', [
    'as' => 'relComEntrada',
    'uses' => 'ContoladorEstoque@relComEntrada'
]);

Route::get('/filtroRelatorio/{id}', [
    'as' => 'filtroRelatorio',
    'uses' => 'ContoladorEstoque@filtroRelatorio'
]);

Route::get('/filtroRelatorioCat/{id}/{opcao}', [
    'as' => 'filtroRelatorioCat',
    'uses' => 'ContoladorEstoque@filtroRelatorioCat'
]);

Route::get('/filtroRelatorioCategorias/{opcao}', [
    'as' => 'filtroRelatorioCategorias',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategorias'
]);

Route::get('/filtroRelatorioCategoriasM/{id}/{mes}', [
    'as' => 'filtroRelatorioCategoriasM',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategoriasM'
]);

Route::get('/filtroRelatorioCategoriasM/{id}/{mes}/{opcao}', [
    'as' => 'filtroRelatorioCategoriasM',
    'uses' => 'ContoladorEstoque@filtroRelatorioCategoriasMCat'
]);

Route::get('/relEntradaMes', [
    'as' => 'relEntradaMes',
    'uses' => 'ContoladorEstoque@relEntradaMes'
]);

Route::post('/novoGrupo', 'ContoladorEstoque@grupo');

Route::put('/novoGrupo/{id}', 'ContoladorEstoque@grupoA');

Route::get('/add_list', 'ContoladorEstoque@mostrarSession');

Route::post('/add_list', 'ContoladorEstoque@entradaSession');

Route::delete('/remover_list/{id}', 'ContoladorEstoque@removerEntrada');

Route::delete('/remover_list', 'ContoladorEstoque@removerTodaEntrada');

Route::resource('/fornecedor', 'ContoladorFornecedor');

Route::resource('/estoque', 'ContoladorEstoque');

Route::get('/categoria', 'ContoladorEstoque@indexJCat');

Route::get('/estoque/busca/material', 'ProdutosControle@buscaProd');

Route::get('/estoque/busca/{unidade}', 'ProdutosControle@busca');

Route::delete('/estoque/busca/{id}', 'ProdutosControle@destroy');

Route::post('/estoque/busca/materialProd', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProduto'
]);

Route::post('/estoque/busca/materialProdM3', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProdutoM3'
]);

Route::post('/estoque/busca/materialProdMTL', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProdutoMTL'
]);

Route::post('/estoque/busca/materialProdUN', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProdutoUN'
]);

Route::post('/estoque/busca/materialProdKG', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProdutoKG'
]);

Route::post('/estoque/busca/materialProdLT', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@estoqueProdutoLT'
]);

Route::put('/estoque/busca/up', [
    'as' => 'materialProd',
    'uses' => 'ProdutosControle@update'
]);

Route::get('/estoque/busca/valorMaterial/{id}', 'ProdutosControle@buscaValor');

Route::get('/estoque/busca/verMaterialProd', 'ProdutosControle@buscaMaterialProd');
