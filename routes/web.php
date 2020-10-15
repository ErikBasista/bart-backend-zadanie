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

/*
|--------------------------------------------------------------------------
| Praca s galeriou
|--------------------------------------------------------------------------
*/
// /gallery
$router->get('/gallery', 'GalleryController@index'); // Zobrazí všetky galérie do objektu "galleries"
$router->post('/gallery', 'GalleryController@insert'); // Vytvorí novú galériu. S tým, istým názvom vytvorí cestu

// /gallery/{path}
$router->get('/gallery/{path}', 'GalleryController@show');
$router->delete('/gallery/{path}', 'GalleryController@index');
$router->post('/gallery/{path}', 'GalleryController@index');

/*
|--------------------------------------------------------------------------
| Praca s obrazkami
|--------------------------------------------------------------------------
*/
// /gallery
$router->get('/images/{w}x{h}/{path}', 'ImageController@index');
