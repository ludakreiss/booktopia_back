<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json(new DataResponse($books));
    }

    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(new ErrorResponse('Book not found'), 404);
        }
        return response()->json(new DataResponse($book));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'book_cover'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);
        $imageName = time().'.'.$request->book_cover->extension();
        $request->book_cover->storeAs('public/book_covers', $imageName); 

         
        $book = Book::create([
        'title' => $request->title,
        'author' => $request->author,
        'book_cover' => 'storage/book_covers/'.$imageName, 
         ]);
        return response()->json(new DataResponse($book), 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(new ErrorResponse('Book not found'), 404);
        }

        $book->update($request->all());
        return response()->json(new DataResponse($book));
    }

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