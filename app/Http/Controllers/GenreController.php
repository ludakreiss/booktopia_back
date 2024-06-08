<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return response()->json(new DataResponse($genres));
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(new ErrorResponse('Genre not found'), 404);
        }
        return response()->json(new DataResponse($genre));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:genres',
        ]);

        $genre = Genre::create($request->all());
        return response()->json(new DataResponse($genre), 201);
    }

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
