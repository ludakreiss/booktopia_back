<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for a successful book creation
     */
    public function test_create_book()
    {
        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'description' => 'This is a test book.',

        ];

        $response = $this->postJson('/api/v1/books', $bookData);
        
        $response->assertStatus(201); // Assert the book creation is successful

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'title',
                'author',
                'description',
                'book_cover',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * Test for failed book creation due to missing data
     */
    public function test_create_book_with_invalid_data()
    {
        $invalidBookData = [
            'author' => 'Missing title', // Missing 'title' field
        ];

        $response = $this->postJson('/api/v1/books', $invalidBookData);
        
        $response->assertStatus(422); // Assert validation error status
        $response->assertJsonValidationErrors(['title']); // Assert validation error for 'title'
    }

    /**
     * Test for successful book retrival by id
     */

    public function test_get_book_by_id()
    {
        $book = Book::factory()->create();

        $response = $this->getJson('/api/v1/books/' . $book->id);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
            ]
        ]);
    }

}


