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


Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/about', AboutContoller::class);



Route::resource('posts', PostController::class)
    ->only(['index', 'show', 'create', 'store']);


Route::get('/recent-posts/{days_age?}', function ($daysAgo = 20) {
    return 'Post from ' . $daysAgo . ' days ago';
})->name('posts.recent.index');


// Route::get('/fun/responses', function () use ($posts) {
//     return response($posts, 200, [
//         'Content-Type' => 'application/json',
//     ])->cookie('foo', 'bar', 3600);
// })->name('fun.responses');



// Route::get('/fun/json', function () use ($posts) {
//     return response()->json($posts);
// });

// Route::get('/fun/download', function () {
//     return response()
//         ->download(public_path('/daniel.jpg'), 'face.jpg');
// });
