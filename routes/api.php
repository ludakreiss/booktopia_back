<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookGenreController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ToBeReadListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Routes
Route::get('v1/login', [AuthController::class, 'login_get']);
Route::post('v1/login', [AuthController::class, 'login_post']);
Route::get('v1/logout', [AuthController::class, 'logout']);
Route::get('v1/refresh', [AuthController::class, 'refresh']);
Route::post('v1/register', [AuthController::class, 'register']);
Route::get('v1/users', [AuthController::class, 'getAllUsers']);
Route::post('v1/update-profile', [AuthController::class, 'updateProfile']);
Route::delete('v1/delete-user', [AuthController::class, 'deleteUser']);



// Book Routes
Route::get('v1/books', [BookController::class, 'index']);
Route::get('v1/books/{id}', [BookController::class, 'show']);
Route::post('v1/books', [BookController::class, 'store']);
Route::put('v1/books/{id}', [BookController::class, 'update']);
Route::delete('v1/books/{id}', [BookController::class, 'destroy']);

// Review Routes
Route::get('v1/reviews', [ReviewController::class, 'index']);
Route::get('v1/reviews/{id}', [ReviewController::class, 'show']);
Route::post('v1/reviews', [ReviewController::class, 'store']);
Route::put('v1/reviews/{id}', [ReviewController::class, 'update']);
Route::delete('v1/reviews/{id}', [ReviewController::class, 'destroy']);

// Genre Routes
Route::get('v1/genres', [GenreController::class, 'index']);
Route::get('v1/genres/{id}', [GenreController::class, 'show']);
Route::post('v1/genres', [GenreController::class, 'store']);
Route::put('v1/genres/{id}', [GenreController::class, 'update']);
Route::delete('v1/genres/{id}', [GenreController::class, 'destroy']);


//To-Be-Read-List Routes
Route::get('v1/to-be-read-list', [ToBeReadListController::class, 'index']);
Route::post('v1/to-be-read-list', [ToBeReadListController::class, 'store']);
Route::delete('v1/to-be-read-list/{id}', [ToBeReadListController::class, 'destroy']);


//BookGenre Routes
Route::get('v1/books/{book_id}/genres', [BookGenreController::class, 'genresByBook']);
Route::get('v1/genres/{genre_id}/books', [BookGenreController::class, 'booksByGenre']);

// Search Routes
Route::get('v1/search/default', [SearchController::class, 'default_search']);
Route::get('v1/search/title', [SearchController::class, 'title_search']);
Route::get('v1/search/author', [SearchController::class, 'author_search']);
Route::get('v1/search/description', [SearchController::class, 'description_search']);