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

    Route::get('/ver', [
        'as' => 'verEstoque',
        'uses' => 'ContoladorEstoque@verEstoque'
    ]);

    Route::prefix('/addItem')->group(function() {
        Route::get('/chapa', [
            'as' => 'addItemEstoqueChapa',
            'uses' => 'ContoladorEstoque@create'
        ]);
    });
    
});

Route::get('/fornecedor', [
        'as' => 'fornecedor',
        'uses' => 'ContoladorFornecedor@indexView'
]);
