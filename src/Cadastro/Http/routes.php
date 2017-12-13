<?php
use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'cadastro', 'middleware' => 'auth' ], function(){


        // OPERADORAS
        Route::get('operadoras/apagados/{id}', 'OperadoraController@showApagado')->name('operadoras.showapagado');     
        Route::get('operadoras/apagados', 'OperadoraController@indexApagados')->name('operadoras.apagados');
        Route::get('operadoras/pesquisarApagados', 'OperadoraController@pesquisarApagados')->name('operadoras.pesquisarApagados');
        Route::get('operadoras/pesquisar', 'OperadoraController@pesquisar')->name('operadoras.pesquisar');
        Route::delete('operadoras/destroySoft/{id}', 'OperadoraController@destroySoft')->name('operadoras.destroySoft');
        Route::get('operadoras/restore/{id}', 'OperadoraController@restore')->name('operadoras.restore');
        
        Route::post('operadoras/getDatatable', 'OperadoraController@getDatatable')->name('operadoras.getDatatable');        
        Route::resource('operadoras', 'OperadoraController'); 



        // SERVIÇOS
        Route::get('servicos/apagados/{id}', 'ServicoController@showApagado')->name('servicos.showapagado');        
        Route::get('servicos/apagados', 'ServicoController@indexApagados')->name('servicos.apagados');
        Route::get('servicos/pesquisarApagados', 'ServicoController@pesquisarApagados')->name('servicos.pesquisarApagados');
        Route::get('servicos/pesquisar', 'ServicoController@pesquisar')->name('servicos.pesquisar');
        Route::delete('servicos/destroySoft/{id}', 'ServicoController@destroySoft')->name('servicos.destroySoft');
        Route::get('servicos/restore/{id}', 'ServicoController@restore')->name('servicos.restore');
       
        Route::post('servicos/getDatatable', 'ServicoController@getDatatable')->name('servicos.getDatatable');        
        Route::resource('servicos', 'ServicoController');



        // PRODUTOS
        Route::get('produtos/apagados/{id}', 'ProdutoController@showApagado')->name('produtos.showapagado');        
        Route::get('produtos/apagados', 'ProdutoController@indexApagados')->name('produtos.apagados');
        Route::get('produtos/pesquisarApagados', 'ProdutoController@pesquisarApagados')->name('produtos.pesquisarApagados');
        Route::get('produtos/pesquisar', 'ProdutoController@pesquisar')->name('produtos.pesquisar');
        Route::delete('produtos/destroySoft/{id}', 'ProdutoController@destroySoft')->name('produtos.destroySoft');
        Route::get('produtos/restore/{id}', 'ProdutoController@restore')->name('produtos.restore');
        
        Route::post('produtos/getDatatable', 'ProdutoController@getDatatable')->name('produtos.getDatatable');        
        Route::resource('produtos', 'ProdutoController'); 


        // MODULO CADASTRO
        Route::get('/', 'CadastroController@index')->name('cadastro');

    });