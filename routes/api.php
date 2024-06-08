<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController;

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


// Book Routes
Route::get('v1/books', [BookController::class, 'index']);
Route::get('v1/books/{book}', [BookController::class, 'show']);
Route::post('v1/books', [BookController::class, 'store']);
Route::put('v1/books/{book}', [BookController::class, 'update']);
Route::delete('v1/books/{book}', [BookController::class, 'destroy']);

// Review Routes
Route::get('v1/reviews', [ReviewController::class, 'index']);
Route::get('v1/reviews/{review}', [ReviewController::class, 'show']);
Route::post('v1/reviews', [ReviewController::class, 'store']);
Route::put('v1/reviews/{review}', [ReviewController::class, 'update']);
Route::delete('v1/reviews/{review}', [ReviewController::class, 'destroy']);

// Genre Routes
Route::get('v1/genres', [GenreController::class, 'index']);
Route::get('v1/genres/{genre}', [GenreController::class, 'show']);
Route::post('v1/genres', [GenreController::class, 'store']);
Route::put('v1/genres/{genre}', [GenreController::class, 'update']);
Route::delete('v1/genres/{genre}', [GenreController::class, 'destroy']);