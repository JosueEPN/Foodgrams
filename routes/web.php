<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

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
    return Redirect::route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [PostController::class,'index'])->name('dashboard');
    Route::get('/dashboard/search', [SearchUserController::class, 'index'])->name('search.index');
    Route::get('/post-create', [PostController::class, 'create'])->name('post.index');
    Route::post('/post-create', [PostController::class, 'store'])->name('post.store');
    Route::get('/post-edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post-update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::post('/post-delete', [PostController::class, 'destroy'])->name('post.delete');
   
});
