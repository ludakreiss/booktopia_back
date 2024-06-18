<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class SearchController extends Controller
{

    public function default_search(Request $request){
        $query = Book::query();
        $data = $request->input('search');
        if($data) {
            $query->whereRaw("title LIKE '%".$data. "%'")
                  ->orWhereRaw("author LIKE '%" . $data . "%'")
                  ->orWhereRaw("description LIKE '%" . $data . "%'");
        }
        return $query->get();
    }
    public function title_search(Request $request){
        $query = Book::query();
        $data = $request->input('search');
        if($data) {
            $query->whereRaw("title LIKE '%".$data. "%'");
        }
        return $query->get();
    }
    public function author_search(Request $request){
        $query = Book::query();
        $data = $request->input('search');
        if($data) {
            $query->WhereRaw("author LIKE '%" . $data . "%'");
                  
        }
        return $query->get();
    }
    public function description_search(Request $request){
        $query = Book::query();
        $data = $request->input('search');
        if($data) {
            $query->WhereRaw("description LIKE '%" . $data . "%'");
        }
        return $query->get();
    }

    
}
