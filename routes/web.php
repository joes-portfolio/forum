<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

// Route::resource('threads', ThreadsController::class);
Route::post('/threads', [ThreadsController::class, 'store'])->middleware('auth');
Route::get('/threads/create', [ThreadsController::class, 'create'])->middleware('auth');
Route::get('/threads/{channel:slug?}', [ThreadsController::class, 'index']);
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show']);
Route::delete('/threads/{channel}/{thread}', [ThreadsController::class, 'destroy'])->middleware('auth');
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store'])->middleware('auth');
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->middleware('auth');
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])->middleware('auth');

Route::get('/profiles/{profileUser:name}', [ProfilesController::class, 'show']);

require __DIR__.'/auth.php';
