<?php

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
Route::get('/threads', [ThreadsController::class, 'index']);
Route::post('/threads', [ThreadsController::class, 'store'])->middleware('auth');
Route::get('/threads/create', [ThreadsController::class, 'create'])->middleware('auth');
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show']);
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store'])->middleware('auth');

require __DIR__.'/auth.php';
