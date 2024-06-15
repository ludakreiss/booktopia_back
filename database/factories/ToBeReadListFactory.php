<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ToBeReadList;
use App\Models\User;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ToBeReadList>
 */
class ToBeReadListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToBeReadList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {return User::inRandomOrder()->first()->id;},  
            'book_id' => function () {return Book::inRandomOrder()->first()->id;},  
            'created_at' => now(),
        ];
    }
}
