<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValue;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [HomeController::class, 'register'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Book
Route::get('/books', [BookController::class, 'index'])->name('books');
Route::get('/book/{id}', [BookController::class, 'show'])->name('getBook');
Route::post('/book/download', [BookController::class, 'download'])->name('downloadBook');
Route::get('/mybooks', [BookController::class, 'my'])->name('myBooks');
Route::get('/mybook/create', [BookController::class, 'create'])->name('createBook');
Route::get('/mybook/{id}/edit', [BookController::class, 'edit'])->name('editBook');
Route::post('/mybook/create', [BookController::class, 'store'])->name('storeBook');
Route::put('/mybook/{id}/edit', [BookController::class, 'update'])->name('updateBook');
Route::delete('/mybook', [BookController::class, 'destroy'])->name('deleteBook');

// Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('updateProfile');
Route::delete('/profile', [ProfileController::class, 'delete'])->name('deleteProfile');

// Favorite
Route::post('/favorite', [ProfileController::class, 'favorite'])->name('favorite');
Route::get('/favorite', [ProfileController::class, 'book'])->name('favoriteBook');
Route::get('/favorite/book/{id}', [ProfileController::class, 'show'])->name('getFavorite');

// Admin
// Admin Books
Route::get('/admin/books', [AdminController::class, 'books'])->name('adminBooks');
Route::get('/admin/book/create', [AdminController::class, 'bookCreate'])->name('adminCreateBook');
Route::post('/admin/book/create', [AdminController::class, 'bookStore'])->name('adminStoreBook');
Route::get('/admin/book/{id}/edit', [AdminController::class, 'bookEdit'])->name('adminEditBook');
Route::put('/admin/book/{id}/edit', [AdminController::class, 'bookUpdate'])->name('adminUpdateBook');
Route::delete('/admin/book', [AdminController::class, 'bookDelete'])->name('adminDeleteBook');

// Admin Users
Route::get('/admin/users', [AdminController::class, 'users'])->name('adminUsers');
Route::get('/user/{id}', [AdminController::class, 'userShow'])->name('adminShowUser');
Route::get('/admin/user/create', [AdminController::class, 'userCreate'])->name('adminCreateUser');
Route::post('/admin/user/create', [AdminController::class, 'userStore'])->name('adminStoreUser');
Route::get('/admin/user/{id}/edit', [AdminController::class, 'userEdit'])->name('adminEditUser');
Route::put('/admin/user/{id}/edit', [AdminController::class, 'userUpdate'])->name('adminUpdateUser');
Route::delete('/admin/user', [AdminController::class, 'userDelete'])->name('adminDeleteUser');

// Admin Category
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('adminCategories');
Route::post('/admin/category', [AdminController::class, 'categoryStore'])->name('adminStoreCategory');
Route::put('/admin/category', [AdminController::class, 'categoryUpdate'])->name('adminUpdateCategory');
Route::delete('/admin/category', [AdminController::class, 'categoryDelete'])->name('adminDeleteCategory');


// Admin Genre
Route::get('/admin/genres', [AdminController::class, 'genres'])->name('adminGenres');
Route::post('/admin/genre', [AdminController::class, 'genreStore'])->name('adminStoreGenre');
Route::put('/admin/genre', [AdminController::class, 'genreUpdate'])->name('adminUpdateGenre');
Route::delete('/admin/genre', [AdminController::class, 'genreDelete'])->name('adminDeleteGenre');



