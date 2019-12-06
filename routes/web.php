<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('/estoque')->group(function() {
    Route::get('/', [
        'as' => 'Estoque',
        'uses' => 'ContoladorEstoque@indexView'
    ]);

    Route::put('/{id}', [
        'as' => 'atualizarEstoque',
        'uses' => 'ContoladorEstoque@update'
    ]);

    Route::get('/ver', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoque'
    ]);

    Route::get('/verChapas', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoqueChapas'
    ]);

    Route::get('/verInflamaveis', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoqueInflamaveis'
    ]);

    Route::get('/verGeral', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoqueGeral'
    ]);

    Route::get('/verTecido', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoqueTecido'
    ]);

    Route::get('/verBaixo', [
        'as' => 'verEstoqueBaixo',
        'uses' => 'ContoladorEstoque@verEstoqueBaixo'
    ]);

    Route::get('/gerarPDF', [
        'as' => 'gerarPDF',
        'uses' => 'ContoladorEstoque@gerarPDF'
    ]);

    Route::prefix('/addItem')->group(function() {
        Route::get('/chapa', [
            'as' => 'addItemEstoqueChapa',
            'uses' => 'ContoladorEstoque@create'
        ]);

        Route::get('/inflamaveis', [
            'as' => 'addItemEstoqueInfla',
            'uses' => 'ContoladorEstoque@createInfla'
        ]);

        Route::get('/geral', [
            'as' => 'addItemEstoqueGeral',
            'uses' => 'ContoladorEstoque@createGeral'
        ]);

        Route::get('/textil', [
            'as' => 'addItemEstoqueTextil',
            'uses' => 'ContoladorEstoque@createTextil'
        ]);
    });

    Route::prefix('/carrinhoEstoque')->group( function() {
        
        Route::get('/', [
            'as' => 'carrinhoPedido',
            'uses' => 'ControladorPedidoEstoque@index'
        ]);

        Route::delete('/removerItemPedido', [
            'as' => 'removerItemPedido',
            'uses' => 'ControladorPedidoEstoque@deletarItem'
        ]);

        Route::put('/addItemPedido', [
            'as' => 'addItemPedido',
            'uses' => 'ControladorPedidoEstoque@addItem'
        ]);

        Route::put('/dimItemPedido', [
            'as' => 'dimItemPedido',
            'uses' => 'ControladorPedidoEstoque@dimItem'
        ]);

        Route::post('/addTudoFornecedor', [
            'as' => 'addTudoFornecedor',
            'uses' => 'ControladorPedidoEstoque@addTudoFornecedor'
        ]);

        Route::get('/excluirPedido/{id}', [
            'as' => 'excluirPedido',
            'uses' => 'ControladorPedidoEstoque@destroy'
        ]);

        Route::post('/enviarEmail', [
            'as' => 'enviarEmail',
            'uses' => 'ControladorPedidoEstoque@enviarEmail'
        ]);
    });

    Route::prefix('/pedidosEstoque')->group(function() {
        Route::get('/enviados', [
            'as' => 'pedidosEstoqueEN',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueEN'
        ]);
        
        Route::get('/autorizados', [
            'as' => 'pedidosEstoqueCP',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueCP'
        ]);

        Route::put('/autorizados', [
            'as' => 'pedidosEstoqueCpId',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueCpId'
        ]);

        Route::put('/atualizar', [
            'as' => 'pedidosEstoqueAtId',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueAtId'
        ]);

        Route::get('/finalizados', [
            'as' => 'pedidosEstoqueFP',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueFP'
        ]);

        Route::put('/finalizados', [
            'as' => 'pedidosEstoqueFpId',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueFpId'
        ]);

        Route::get('/entrada', [
            'as' => 'pedidosEstoqueOK',
            'uses' => 'ControladorPedidoEstoque@pedidosEstoqueOK'
        ]);
    });

    Route::get('/adicionarPedido', function() {
        return redirect()->route('verEstoqueBaixo');
    });
    
    Route::get('/estoqueFornecedor/{id}', [
        'as' => 'estoqueFornecedor',
        'uses' => 'ControladorPedidoEstoque@estoqueFornecedor'
    ]);
});

Route::get('/fornecedor', [
        'as' => 'fornecedor',
        'uses' => 'ContoladorFornecedor@indexView'
]);
