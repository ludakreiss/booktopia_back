<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataResponse;
use App\Models\SuccessResponse;
use App\Models\ErrorResponse;
use App\Models\ToBeReadList;

class ToBeReadListController extends Controller
{
    public function __construct(){

        $this->middleware('auth:api');
    }


    public function index(){

        $userId = Auth::id();

        $toBeReadBooks = ToBeReadList::where('user_id', $userId)->with('book')->get();

        return response()->json(new DataResponse($toBeReadBooks));
    }

    public function store(Request $request){

        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $userId = Auth::id();
        $existingEntry = ToBeReadList::where('user_id', $userId)->where('book_id', $request->book_id)->first();


        if($existingEntry){
            return response()->json(new ErrorResponse('Book is already in your to-be-read-list'), 409);
        }

        $toBeReadEntry = ToBeReadList::create([
            'user_id'=>$userId,
            'book_id'=> $request->book_id,
        ]);

        return response()->json(new DataResponse($toBeReadEntry));
    }


    public function destroy($id){
        $userId = Auth::id();

        $toBeReadEntry = ToBeReadList::where('user_id', $userId)->where('book_id', $id)->first();

        if(!$toBeReadEntry){
            return response()->json(new ErrorResponse('Book not found in your to-be-read list'), 404);
        }

        $toBeReadEntry->delete();
        return response()->json(new SuccessResponse('Book removed from your to-be-read list'), 201);
    }

}

