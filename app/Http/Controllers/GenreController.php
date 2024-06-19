<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;

/**
 * Class GenreController
 *
 * Controller for managing genres.
 *
 * @package App\Http\Controllers
 */
class GenreController extends Controller
{
    /**
     * Display a listing of genres.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json(new DataResponse($genres));
    }

    /**
     * Display the specified genre.
     *
     * @param int $id The ID of the genre.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(new ErrorResponse('Genre not found'), 404);
        }
        return response()->json(new DataResponse($genre));
    }

    /**
     * Store a newly created genre in storage.
     *
     * @param \Illuminate\Http\Request $request The request object containing the genre data.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:genres',
        ]);

        $genre = Genre::create($request->all());
        return response()->json(new DataResponse($genre), 201);
    }

    /**
     * Update the specified genre in storage.
     *
     * @param \Illuminate\Http\Request $request The request object containing the updated genre data.
     * @param int $id The ID of the genre to update.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(new ErrorResponse('Genre not found'), 404);
        }

        $request->validate([
            'name' => 'required|string|max:50|unique:genres,name,' . $id,
        ]);

        $genre->update($request->all());
        return response()->json(new DataResponse($genre));
    }

    /**
     * Remove the specified genre from storage.
     *
     * @param int $id The ID of the genre.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(new ErrorResponse('Genre not found'), 404);
        }

        $genre->delete();
        return response()->json(new SuccessResponse());
    }
}
