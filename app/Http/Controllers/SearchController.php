<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

/**
 * Class SearchController
 *
 * Controller for handling search operations on books.
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{

    public function search(Request $request){
        $query = Book::query();
        $data = $request->input('search');
        if($data) {
            $query->whereRaw("title LIKE '%".$data. "%'");
        }
        return $query->get();
    }
}