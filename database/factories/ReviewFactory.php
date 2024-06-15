<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\User;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {return User::inRandomOrder()->first()->id;},
            'book_id' => function () use (&$book) {
                            $book = Book::inRandomOrder()->first();
                            return $book->id;},
            'title' =>function () use (&$book) {return $book->title;},
            'rating' => $this->faker->numberBetween(1, 5), 
            'review_text' => $this->faker->paragraph(), 
            'created_at' => now(),
        ];
    }
}
