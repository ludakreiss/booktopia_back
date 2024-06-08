<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response()->json(new DataResponse($reviews));
    }

    public function show($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(new ErrorResponse('Review not found'), 404);
        }
        return response()->json(new DataResponse($review));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'nullable|string',
        ]);

        $review = Review::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return response()->json(new DataResponse($review), 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(new ErrorResponse('Review not found'), 404);
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'nullable|string',
        ]);

        $review->update($request->all());
        return response()->json(new DataResponse($review));
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(new ErrorResponse('Review not found'), 404);
        }

        $review->delete();
        return response()->json(new SuccessResponse());
    }
}
