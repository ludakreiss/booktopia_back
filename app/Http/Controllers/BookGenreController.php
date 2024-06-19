<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;
use App\Models\BookGenre;
use App\Models\Genre;
use App\Models\Book;

/**
 * Class BookGenreController
 *
 * Controller for managing the relationships between books and genres.
 *
 * @package App\Http\Controllers
 */
class BookGenreController extends Controller
{
    /**
     * Display a listing of books with their genres.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get all books with their genres
        $books = Book::with('genres')->get();

        return response()->json($books);
    }

    /**
     * Display the genres associated with a specific book.
     *
     * @param int $book_id The ID of the book.
     * @return \Illuminate\Http\JsonResponse
     */
    public function genresByBook($book_id)
    {
        $book = Book::with('genres')->find($book_id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book->genres);
    }

    /**
     * Display the books associated with a specific genre.
     *
     * @param int $genre_id The ID of the genre.
     * @return \Illuminate\Http\JsonResponse
     */
    public function booksByGenre($genre_id)
    {
        $genre = Genre::with('books')->find($genre_id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre->books);
    }
}
