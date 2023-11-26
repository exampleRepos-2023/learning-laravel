<?php

use App\Http\Controllers\AboutContoller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Define a route for the home page with the HomeController's 'home' method as the callback function
// Set the route name as 'home.index'
// Apply the 'auth' middleware to this route
Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');
// ->middleware('auth');

// Define a route for the contact page with the HomeController's 'contact' method as the callback function
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/secret', [HomeController::class, 'secret'])
    ->middleware('can:home.secret')
    ->name('secret');

// Define a route for the about page with the AboutController as the callback function
Route::get('/about', AboutContoller::class);

// Define a resourceful route group for the 'posts' resource (index, show, create, store, edit, update, destroy)
Route::resource('posts', PostController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

// Define a route for the 'recent-posts' page with an optional 'days_age' parameter
// The callback function returns a string indicating the number of days ago
// If no 'days_age' is provided, default to 20
// Set the route name as 'posts.recent.index'
Route::get('/recent-posts/{days_age?}', function ($daysAgo = 20) {
    return 'Post from ' . $daysAgo . ' days ago';
})->name('posts.recent.index');

// Enable authentication routes (login, register, etc.)
Auth::routes();
