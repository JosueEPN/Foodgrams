<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OfflineController;
use App\Http\Controllers\OnlineController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/post-create', [PostController::class, 'create']);
Route::post('/post-store', [PostController::class, 'store']);

//Post



//Admin


    Route::get('/Admin/user/all', [AdminController::class, 'indexUserApi']);
    Route::get('/Admin/post/all', [AdminController::class, 'indexPostApi']);
    Route::get('/admin/{user}/edit',[AdminController::class,'editUserApi']);
    Route::post('/Admin/update',[AdminController::class,'updateUserApi']);
    Route::delete('/admin/{user}/delete',[AdminController::class,'deleteUserApi']);
    Route::get('/Admin/post/{post}/{user}/edit', [AdminController::class, 'showPostApi']);
    Route::delete('/Admin/post/{post}/{user}/delete', [AdminController::class, 'destroyPostApi']);
    Route::post('/Admin/user/register',[AdminController::class,'registerApi']);
    Route::post('/Admin/post/update',[PostController::class,'updatePostApi']);



 
//Chat
Route::get('/chats', [ChatController::class,'chatAll']);
Route::get('/chat/{id}', [ChatController::class,'checkChatApi']);

//User
Route::get('/{user}/edit',[ProfileController::class,'editUserApi']);
Route::post('/update',[ProfileController::class,'updateUserApi']);
Route::delete('/{user}/delete',[ProfileController::class,'deleteUserApi']);
Route::post('/user/register',[ProfileController::class,'registerApi']);
//Post
Route::get('/post/{post}/{user}/edit', [PostController::class, 'showPostApi']);
Route::get('/post/{post}/{user}/delete', [PostController::class, 'destroyPostApi']);
Route::post('/post/update', [PostController::class, 'updatePostApi']);
Route::post('/post-create', [PostController::class, 'createApi']);