<?php

use App\Http\Controllers\API\V1\BookController;
use App\Http\Controllers\API\V1\PublisherController;
use App\Http\Controllers\API\V1\SearchController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\GenreController;

Route::get('/genre/get', [GenreController::class, 'get']);
Route::get('/publisher/get', [PublisherController::class, 'get']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/book/create', [BookController::class, 'store']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
});
Route::put('/book/edit', [BookController::class, 'update']);
Route::delete('/book/delete/{book}', [BookController::class, 'delete']);
Route::get('/book/get/{book}', [BookController::class, 'get']);
Route::get('/book/getBookList', [BookController::class, 'getBookList']);
Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);
Route::get('/search', [SearchController::class, 'search']);
Route::post('/upload-media', [BookController::class, 'upload']);
Route::get('/get-media/{media}', [BookController::class, 'getMedia']);
Route::get('/filter', [BookController::class, 'filter']);
Route::get('/author', [BookController::class, 'getAuthor']);
Route::get('/genre', [BookController::class, 'getGenre']);
