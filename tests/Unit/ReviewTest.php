<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Review;
use App\Models\User;
use App\Models\Book;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for successful revieew creation
     */

    public function test_create_review()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reviewData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'title' => 'Great Book!',
            'rating' => 5,
            'review_text' => 'This book is amazing!',
        ];

        $response = $this->postJson('/api/v1/reviews', $reviewData);
        
        $response->assertStatus(201); // Assert the review creation is successful

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'user_id',
                'book_id',
                'title',
                'rating',
                'review_text',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * Test for failed review creation due to missing field and invalid field
     */

    public function test_create_review_with_invalid_data()
    {
        $invalidReviewData = [
            'title' => '', // Missing required 'title' field
            'rating' => 'not_a_number', // Invalid 'rating' field
        ];

        $response = $this->postJson('/api/v1/reviews', $invalidReviewData);
        
        $response->assertStatus(422); // Assert validation error status
        $response->assertJsonValidationErrors(['title', 'rating']); // Assert validation errors for 'title' and 'rating'
    }
}
