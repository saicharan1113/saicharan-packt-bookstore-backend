<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\User;
use App\Traits\GeneralHelperTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    use GeneralHelperTrait;

    /**
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $author = User::ROLES;

        return [
            'title' => $this->faker->company,
            'uniqueBookId' => $this->generateUniqueId(),
            'genreId' => Genre::inRandomOrder()->first(),
            'authorId' => User::where('role', 'AUTHOR')->first(),
            'publisherId' => Publisher::inRandomOrder()->first(),
            'image' => $this->faker->imageUrl(),
            'isbn' => $this->faker->isbn13(),
            'description' => $this->faker->realText
        ];
    }
}
