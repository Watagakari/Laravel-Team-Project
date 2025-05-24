<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Librarycontroller;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return view('index');
})->name('login');

// Register
Route::post('/register', [UserController::class, 'register']);
Route::post('/register/create', [UserController::class, 'create']);

// Login dan Logout
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Protected Routes (Hanya untuk yang sudah login)
Route::middleware('auth')->group(function () {

    // Home & personal spaces
    Route::get('/personal', [UserController::class, 'index']);
    Route::get('/home', [UserController::class, 'indexAll']);

    // Post
    Route::post('/create-post', [PostController::class, 'createPost']);
    Route::get('/edit-post/{post}', [PostController::class, 'EditScreen']);
    Route::put('/edit-post/{post}', [PostController::class, 'UpdatePost']);
    Route::delete('/delete-post/{post}', [PostController::class, 'DeletePost']);

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

    // Save a post (attach post to user)
    Route::post('/library/save/{post}', [LibraryController::class, 'save'])->name('library.save')->middleware('auth');

    // Unsave a post (detach post from user)
    Route::delete('/library/unsave/{post}', [LibraryController::class, 'unsave'])->name('library.unsave')->middleware('auth');

});
