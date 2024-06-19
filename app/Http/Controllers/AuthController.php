<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;

/**
 * Class BookController
 *
 * Controller for managing books.
 *
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    /**
     * Display a listing of books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = Book::all();
        return response()->json(new DataResponse($books));
    }

    /**
     * Display the specified book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(new ErrorResponse('Book not found'), 404);
        }
        return response()->json(new DataResponse($book));
    }

    /**
     * Store a newly created book in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $bookCoverPath = null;
    
        if ($request->hasFile('book_cover')) {
            $imageName = time().'.'.$request->book_cover->extension();
            $request->book_cover->storeAs('public/book_covers', $imageName);
            $bookCoverPath = 'storage/book_covers/'.$imageName;
        }
    
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'book_cover' => $bookCoverPath, 
        ]);
    
        return response()->json(new DataResponse($book), 201);
    }

    /**
     * Remove the specified book from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(new ErrorResponse('Book not found'), 404);
        }

        $book->delete();
        return response()->json(new SuccessResponse());
    }
}
