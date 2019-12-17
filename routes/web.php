<?php
Auth::routes();

// Cria nova postagem
Route::get('/posts/novo', 'PostsController@novo');

// Cria nova postagem
Route::post('/posts/novo', 'PostsController@cria_post');

// Área do admin
Route::get('/home', 'HomeController@index')->name('home');

// Altera o modo de exibição
Route::post('/postagem/ativa/{id}', 'PostsController@ativa_post');

// Exclui post
Route::post('/postagem/remove/{id}', 'PostsController@destroy');

// Edita titulo
Route::post('/postagem/edita/titulo/{id}', 'PostsController@edita_titulo');

// Edita descricao
Route::post('/postagem/edita/descricao/{id}', 'PostsController@edita_descricao');

// Edita imagem
Route::post('/postagem/edita/imagem/{id}', 'PostsController@edita_imagem');

// Postagem específica
Route::get('/postagem/{id}', 'PublicController@postagem');

// Root (página inicial)
Route::get('/', 'PublicController@index');