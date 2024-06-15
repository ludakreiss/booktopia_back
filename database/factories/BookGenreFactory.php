<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Genre;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookGenre>
 */
class BookGenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => function () {return Book::inRandomOrder()->first()->id;},
            'genre_id' => function () {return Book::inRandomOrder()->first()->id;}
        ];
    }
}
