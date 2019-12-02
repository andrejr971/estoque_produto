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
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoqueBaixo'
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
    
});

Route::get('/fornecedor', [
        'as' => 'fornecedor',
        'uses' => 'ContoladorFornecedor@indexView'
]);
