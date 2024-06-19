<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;
use App\Models\ToBeReadList;

/**
 * Class ToBeReadListController
 *
 * Controller for managing the user's to-be-read list.
 *
 * @package App\Http\Controllers
 */
class ToBeReadListController extends Controller
{
    /**
     * Constructor method to apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of books in the user's to-be-read list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();

        $toBeReadBooks = ToBeReadList::where('user_id', $userId)->with('book')->get();

        return response()->json(new DataResponse($toBeReadBooks));
    }

    /**
     * Store a newly book in the user's to-be-read list.
     *
     * @param \Illuminate\Http\Request $request The request object containing the book_id to be added.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $userId = Auth::id();
        $existingEntry = ToBeReadList::where('user_id', $userId)->where('book_id', $request->book_id)->first();

        if ($existingEntry) {
            return response()->json(new ErrorResponse('Book is already in your to-be-read-list'), 409);
        }

        $toBeReadEntry = ToBeReadList::create([
            'user_id' => $userId,
            'book_id' => $request->book_id,
        ]);

        return response()->json(new DataResponse($toBeReadEntry));
    }

    /**
     * Remove a book from the user's to-be-read list.
     *
     * @param int $id The ID of the book to be removed from the list.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $userId = Auth::id();

        $toBeReadEntry = ToBeReadList::where('user_id', $userId)->where('book_id', $id)->first();

        if (!$toBeReadEntry) {
            return response()->json(new ErrorResponse('Book not found in your to-be-read list'), 404);
        }

        $toBeReadEntry->delete();
        return response()->json(new SuccessResponse('Book removed from your to-be-read list'), 201);
    }
}

