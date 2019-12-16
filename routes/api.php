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

Route::post('/novoGrupo', 'ContoladorEstoque@grupo');

Route::put('/novoGrupo/{id}', 'ContoladorEstoque@grupoA');

Route::get('/add_list', 'ContoladorEstoque@mostrarSession');

Route::post('/add_list', 'ContoladorEstoque@entradaSession');

Route::delete('/remover_list/{id}', 'ContoladorEstoque@removerEntrada');

Route::delete('/remover_list', 'ContoladorEstoque@removerTodaEntrada');

Route::resource('/fornecedor', 'ContoladorFornecedor');

Route::resource('/estoque', 'ContoladorEstoque');

Route::get('/categoria', 'ContoladorEstoque@indexJCat');
