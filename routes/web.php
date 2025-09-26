<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Movie;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| หน้าแรก
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $movies = Movie::all(); 
    return view('home', compact('movies'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth / Register
|--------------------------------------------------------------------------
*/
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Auth::routes(); // Login / Logout / Password Reset

// ลบ route /home เพราะเราจะใช้หน้า / เป็นหลัก
// Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Movies (ทั่วไป)
|--------------------------------------------------------------------------
*/
Route::get('/movies', function () {
    $movies = Movie::all(); 
    return view('movies.index', compact('movies'));
})->name('movies.list');

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/
Route::get('/categories', function () {
    $categories = Category::all();
    return view('categories.index', compact('categories'));
})->name('categories.list');

Route::get('/categories/{id}', function ($id) {
    $category = Category::findOrFail($id);
    $movies = $category->movies;
    return view('categories.show', compact('category', 'movies'));
})->name('categories.show');

/*
|--------------------------------------------------------------------------
| Favorite
|--------------------------------------------------------------------------
*/
Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'store'])->name('movies.favorite');
Route::delete('/movies/{movie}/favorite', [FavoriteController::class, 'destroy'])->name('movies.unfavorite');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function() {
    Route::resource('movies', MovieController::class);
});

/*
|--------------------------------------------------------------------------
| Routes สำหรับผู้ใช้ที่ต้อง login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Comment Routes
    Route::post('/comments', [CommentController::class,'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

 
});