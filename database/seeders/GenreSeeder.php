<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Traits\GeneralHelperTrait;
use Database\Factories\GenreFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    use GeneralHelperTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = Genre::GENRES;
        foreach ($genres as $genre) {

            Genre::updateOrCreate(
                ['name' => $genre],
                ['uniqueGenreId' => $this->generateUniqueId()]
            );
        }
    }
}
