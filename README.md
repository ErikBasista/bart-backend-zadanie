# Laravel Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Popis k vypracovanému zadaniu

Zadanie som vypracoval v Lumen PHP Frameworku. Mikro-framework Laravelu. Tento mikro-framework považujem za vhodnú voľbu pre tvorbu API riešení v back-ende. Nakoľko sa v poslednom čase venujem práve vývoju API, rozhodol som sa pre tento framework, nakoľko obsahuje len tie najdôležitejšie metódy pre prácu malých projektov a nezaberá toľko kapacity navyše čo samotný Laravel. [Lumen website](https://lumen.laravel.com/docs).

## 1. API dokumentácia
### 1.1. Výpis všetkých galérií z databázy

Request:
```
metóda GET /gallery
```
Zodpovedný route:
```
$router->get('/gallery', 'GalleryController@index'); // Zobrazí všetky galérie do objektu "galleries"
```
Response výsledkov
```
{
    "galleries": [
        {
            "name": "Antigua and Barbuda",
            "path": "Antigua%20and%20Barbuda"
        },
        {
            "name": "Mali",
            "path": "Mali"
        },
        {
            "name": "Bosnia and Herzegovina",
            "path": "Bosnia%20and%20Herzegovina"
        },
        {
            "name": "Denmark",
            "path": "Denmark"
        },
        {
            "name": "Paraguay",
            "path": "Paraguay"
        },
        {
            "name": "Yemen",
            "path": "Yemen"
        },
        {
            "name": "Philippines",
            "path": "Philippines"
        },
        {
            "name": "Namibia",
            "path": "Namibia"
        },
        {
            "name": "Cyprus",
            "path": "Cyprus"
        },
        {
            "name": "Nigeria",
            "path": "Nigeria"
        }
    ]
}
```
### 1.2. Zoznam obrázkov v galérii.

Request:

Ukážka obsahu obrázkov v galérii pod názvom "Mali":
```
GET http://localhost/bart.sk/public/gallery/Mali
```
Response:
```
{
    "gallery": {
        "1": {
            "name": "Mali",
            "path": "Mali"
        }
    },
    "images": [
        {
            "name": "Vylet",
            "path": "vylet.jpg",
            "fullpath": "vylet.jpg",
            "modified": "1977-06-06 10:09:41"
        },
        {
            "name": "Tance",
            "path": "tance.jpg",
            "fullpath": "tance.jpg",
            "modified": "2019-05-16 03:42:33"
        },
        {
            "name": "Party",
            "path": "party.jpg",
            "fullpath": "party.jpg",
            "modified": "1974-01-26 21:36:50"
        }
    ]
}
```
V prípade, ak galéria neobsahuje žiadne obrázky, získame response so zoznamom obrázkov v prázdnom poli:
```
Request: GET /gallery/Denmark
```
```
{
    "gallery": {
        {
            "name": "Denmark",
            "path": "Denmark"
        }
    },
    "images": []
}
```
### 1.3. Vytvorenie novej galérie.

Request:
```
POST /gallery
{
    "name": "Nova Galeria",
}
```
Response
```
{
    "name": "Nova Galeria",
    "path": "nova%20galeria"
}
```
Ak galéria už v databáze existuje, vráti chybový response 409:
Request:
```
POST /gallery
{
    "name": "Nova Galeria",
}
```
Response:
```
{
    "chyba": "Galéria so zadaným názvom už existuje"
}
```
Zabezpečovacie metódy:
- public function galleryExists($path) // Pomocná funkcia pre vygenerovanie aktuálneho timestamp
- private function hasStringSlash($string) // Funkcia zisťuje, či máme v stringu lomítko (slash) 
### 1.4. Vymazanie galérie
Request:
```
DELETE /gallery/nova%20galeria
```
Response:
```
{
    "message": "Galéria bola úspešne vymazaná"
}
```

### 1.5. Upload obrázku do zvolenej galérie
Request (príklad):
```
POST /gallery/Yemen
```
```
{
    'image' : 'giraffe.jpg',
    'gallery_path' : 'Yemen'
}
```

Response:
```
{
    "uploaded": {
        "path": "giraffe.jpg",
        "fullpath": "Yemen/giraffe.jpg",
        "name": "giraffe",
        "modified": "2020-10-17 14:52:38"
    }
}
```
Výsledok vloženého obrázku do galérie Yemen k ostatným obrázkom
```
{
    "gallery": {
        "5": {
            "name": "Yemen",
            "path": "Yemen"
        }
    },
    "images": [
        {
            "name": "Plaz",
            "path": "plaz.jpg",
            "fullpath": "plaz.jpg",
            "modified": "2001-10-23 05:01:20"
        },
        {
            "name": "Elephant",
            "path": "elephant.jpg",
            "fullpath": "Yemen/elephant.jpg",
            "modified": "2020-10-17 09:19:05"
        },
        {
            "name": "giraffe",
            "path": "giraffe.jpg",
            "fullpath": "Yemen/giraffe.jpg",
            "modified": "2020-10-17 14:52:38"
        }
    ]
}
```
Obrázok sa uploadne následne v našom prípade do priečinka: "/public/images/Yemen/"

### 1.6. Vygenerovanie náhľadového obrázku
Request (príklad existujúceho obrázka v galérii Yemen):
```
GET /images/300x400/Yemen/giraffe.jpg
```
Response:
```
Vygeneruje sa obázok z galérie typu: image/jpeg
Jeho umiestnenie sa nachádza v: public/images/Nazov_galerie/Nazov_obrazku.jpg
```
## 2. Postup a kroky vypracovania backend zadania
### 2.1. Použil som: IDE PhpStorm, Postman a Github
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
$router->post('/gallery/{path}', 'GalleryController@upload');   // Upload obrázku do zvolenej galérie. 

// /gallery
$router->get('/images/{w}x{h}/{path}/{image}', 'ImageController@render'); // Vygenerovanie náhľadového obrázku

// Potreboval som pripojiť ešte segment {image}, aby som mohol rozdeliť URI na cestu priečinku a obrázku.

```
### 2.2. Databáza sqlite
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
### 2.3. Modely
Vytvorené modely pre ťahanie údajov z polí v databáze sqlite
- app/Gallery.php
- app/Image.php

### 2.4. Trait
Vytvoril som globálny ApiResponser, pre volanie funkcií s jednotlivými response hodnotami

- app/Traits/ApiResponser.php

### 2.5. Controllery
Následné Controllery pre spracovávanie requestov

- app/Http/Controllers/GalleryController.php // pre prácu s galériami
- app/Http/Controllers/ImageController.php // pre prácu s obrázkami
- app/Http/Controllers/ImageUploadController.php // controller pre upload obrázkov do galérie

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
