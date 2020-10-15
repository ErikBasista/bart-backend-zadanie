<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Gallery;
use App\Image;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Gallery::class, function (Faker $faker) {
    $name = $faker->country;
    $path = rawurlencode($name);

    return [
        'path' => $path,
        'name' => $name
    ];
});


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
