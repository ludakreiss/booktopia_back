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
    /**
     * Perform a default search on books.
     * Searches in the title, author, and description fields.
     *
     * @param \Illuminate\Http\Request $request The request object containing the search query.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function default_search(Request $request)
    {
        $query = Book::query();
        $data = $request->input('search');
        if ($data) {
            $query->whereRaw("title LIKE '%" . $data . "%'")
                  ->orWhereRaw("author LIKE '%" . $data . "%'")
                  ->orWhereRaw("description LIKE '%" . $data . "%'");
        }
        return $query->get();
    }

    /**
     * Perform a search on books by title.
     *
     * @param \Illuminate\Http\Request $request The request object containing the search query.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function title_search(Request $request)
    {
        $query = Book::query();
        $data = $request->input('search');
        if ($data) {
            $query->whereRaw("title LIKE '%" . $data . "%'");
        }
        return $query->get();
    }

    /**
     * Perform a search on books by author.
     *
     * @param \Illuminate\Http\Request $request The request object containing the search query.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function author_search(Request $request)
    {
        $query = Book::query();
        $data = $request->input('search');
        if ($data) {
            $query->whereRaw("author LIKE '%" . $data . "%'");
        }
        return $query->get();
    }

    /**
     * Perform a search on books by description.
     *
     * @param \Illuminate\Http\Request $request The request object containing the search query.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function description_search(Request $request)
    {
        $query = Book::query();
        $data = $request->input('search');
        if ($data) {
            $query->whereRaw("description LIKE '%" . $data . "%'");
        }
        return $query->get();
    }
}
