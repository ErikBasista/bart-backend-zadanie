<?php

use App\Gallery;
use App\Image;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        factory(Gallery::class, 10)->create();
        factory(Image::class, 10)->create();
    }
}
