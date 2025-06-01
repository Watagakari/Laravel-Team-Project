<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CategoryController;

// Guest Routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return view('index');
})->name('login');

Route::post('/register', [UserController::class, 'register']);
Route::post('/register/create', [UserController::class, 'create']);
Route::post('/login', [UserController::class, 'login']);

// Protected Routes
Route::middleware('auth')->group(function () {
    // Authentication
    Route::post('/logout', [UserController::class, 'logout']);

    // Home & Personal Spaces
    Route::get('/home', [UserController::class, 'indexAll'])->name('home');
    Route::get('/personal', [UserController::class, 'index'])->name('personal');

    // Profile
    Route::get('/profile', function () {
        $user = auth()->user();
        $posts = $user->userPosts()->latest()->get();
        return view('profile', compact('user', 'posts'));
    })->name('profile');
    Route::delete('/profile/delete', [UserController::class, 'delete'])->name('profile.delete');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

    // Posts
    Route::post('/create-post', [PostController::class, 'createPost'])->name('posts.create');
    Route::get('/edit-post/{post}', [PostController::class, 'EditScreen'])->name('posts.edit');
    Route::put('/edit-post/{post}', [PostController::class, 'UpdatePost'])->name('posts.update');
    Route::delete('/delete-post/{post}', [PostController::class, 'DeletePost'])->name('posts.delete');

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/{post}', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{post}', [LibraryController::class, 'destroy'])->name('library.unsave');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Category API endpoints
    Route::get('/api/categories', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::post('/api/categories', [CategoryController::class, 'store'])->name('api.categories.store');
});
