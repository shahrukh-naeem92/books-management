<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('external-books', 'BooksController@getBooksFromIceAndFireApi');
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->post('books', 'BooksController@createBook');
        $router->get('books', 'BooksController@getAllBooks');
        $router->get('books/{id:[0-9]+}', 'BooksController@getBook');
        $router->delete('books/{id:[0-9]+}', 'BooksController@deleteBook');
        $router->patch('books/{id:[0-9]+}', 'BooksController@updateBook');
    });
});
