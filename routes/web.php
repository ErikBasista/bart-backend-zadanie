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
| testovací route pre FACEBOOK
|--------------------------------------------------------------------------
| Oficiálna Dokumentácia: https://github.com/facebookarchive/php-graph-sdk/tree/master/docs
*/
$router->get('/facebook', function () use ($router) {
    $fb_login = new Facebook\Facebook([
        'app_id' => '1053174974861205',
        'app_secret' => 'token',
        'default_graph_version' => 'v2.10',
    ]);

    $helper = $fb_login->getRedirectLoginHelper();

    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('https://localhost/token', $permissions);

    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
});

/*
|--------------------------------------------------------------------------
| Praca s galeriou
|--------------------------------------------------------------------------
*/
// /gallery
$router->get('/gallery', 'GalleryController@index');            // Zobrazí všetky galérie do objektu "galleries"
$router->post('/gallery', 'GalleryController@insert');          // Vytvorí novú galériu. S tým, istým názvom vytvorí cestu

// /gallery/{path}
$router->get('/gallery/{path}', 'GalleryController@show');      // Ukáže konkrétnu galériu a jej prisluchajúce obrázky
$router->delete('/gallery/{path}', 'GalleryController@delete'); // Vymazanie zvolenej galérie, alebo obrázku
$router->post('/gallery/{path}', 'GalleryController@upload');   // Upload obrázku do zvolenej galérie

/*
|--------------------------------------------------------------------------
| Praca s obrazkami
|--------------------------------------------------------------------------
*/
// /gallery
$router->get('/images/{w}x{h}/{path}/{image}', 'ImageController@render'); // Vygenerovanie náhľadového obrázku
