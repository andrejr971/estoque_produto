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

Route::resource('/fornecedor', 'ContoladorFornecedor');

Route::resource('/estoque', 'ContoladorEstoque');