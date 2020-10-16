# Laravel Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Popis k vypracovanému zadaniu

Zadanie som vypracoval v Lumen PHP Frameworku. Mikro-framework Laravelu. Tento mikro-framework považujem za vhodnú voľbu pre tvorbu API riešení v back-ende. Nakoľko sa v poslednom čase venujem práve vývoju API, rozhodol som sa pre tento framework, nakoľko obsahuje len tie najdôležitejšie metódy pre prácu malých projektov a nezaberá toľko kapacity navyše čo samotný Laravel. [Lumen website](https://lumen.laravel.com/docs).

## API dokumentácia
### Výpis všetkých galérií z databázy

Request:
```
metóda GET /gallery
```
Zodpovedný route:
```
$router->get('/gallery', 'GalleryController@index'); // Zobrazí všetky galérie do objektu "galleries"
```
Response výsledkov

### Výpis všetkých galérií z databázy.
### Vytvorenie novej galérie.
### Zoznam obrázkov v galérii.

## Postup a kroky vypracovania backend zadania
### Použil som: IDE PhpStorm, Postman a Github
- Počas testovania celej kvality naprogramovaného API som používal Postman pre odosielanie requestov
- Vývoj API som realizoval pomocou IDE prostredia PhpStorm
- Zmeny v kóde som commitoval parimo na Github
- Popri programovaniu som priebežne doplňal informácie do README.md
- Pri prípadných problémoch v kódovaní som použil vyhľadávanie segmentov kódu v komunite Stackowerflow.com, dokumentáciu Laravel a Lumen, tiež články na medium.com a iné.
### Route

Vytvoril som základný routing odkazujúci sa na metódy v Controlleri pre prácu s galériami.

routes/web.php:
```
// /gallery
$router->get('/gallery', 'GalleryController@index');            // Zobrazí všetky galérie do objektu "galleries"
$router->post('/gallery', 'GalleryController@insert');          // Vytvorí novú galériu. S tým, istým názvom vytvorí cestu

// /gallery/{path}
$router->get('/gallery/{path}', 'GalleryController@show');      // Ukáže konkrétnu galériu a jej prisluchajúce obrázky
$router->delete('/gallery/{path}', 'GalleryController@delete'); // Vymazanie zvolenej galérie, alebo obrázku
$router->post('/gallery/{path}', 'GalleryController@upload');   // Upload obrázku do zvolenej galérie

// /gallery
$router->get('/images/{w}x{h}/{path}', 'ImageController@render'); // Vygenerovanie náhľadového obrázku
```
### Databáza sqlite
Databáza je fiktívna, vytvorená cez migrations. Do databázy som uložil náhodne vygenerované údaje pomocou funkcie Factory/Seeder.

- Vytvoril som prázdny súbor database.sqlite do ktorého som vložil náhodne vygenerované názvy galérie a obrázkov.
- v .env konfig. súbore som nakonfiguroval odkaz na fiktívnu databázu na zvolený súbor database/database.sqlite
```
...
DB_CONNECTION=sqlite
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=homestead
#DB_USERNAME=homestead
#DB_PASSWORD=secret
...
```

Následne vytvorené migrations.
```
php artisan make:migration create_gallery_table --create=galleries
php artisan make:migration create_table_images --create=images
php artisan migrate
```
- database/factories/ModelFactory.php   // zadefinoval som hodnoty, ktoré sa majú naplňať do sqlite databázy
```
ModelFactory.php:

use App\Gallery;
use App\Image;
use Faker\Generator as Faker;

// vygeneruje hodnoty náhodných názvov a potrebných údajov databázy pre tabuľku galleries
$factory->define(Gallery::class, function (Faker $faker) {
    $name = $faker->country;
    $path = rawurlencode($name);

    return [
        'path' => $path,
        'name' => $name
    ];
});

// vygeneruje hodnoty náhodných názvov a potrebných údajov databázy pre tabuľku images
$factory->define(Image::class, function (Faker $faker) {

    $name_of_image = $faker->randomElement(['Vylet', 'Plaz', 'Party', 'Tance', 'Jazda', 'Navsteva']);
    $full_name_of_image = $name_of_image;
    $full_name_of_image = $full_name_of_image .= '.jpg';

    return [
        'id_gallery' => $id_gallery = $faker->randomElement(['2', '4', '6', '8', '9', '10']),
        'name' => $name_of_image,
        'path' => $full_name_of_image = strtolower($full_name_of_image),
        'fullpath' => 'path',
    ];
});
```
Následne príkaz pre spustenie naplnenia databázy do tabuliek:
```
php artisan db:seed
```

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
