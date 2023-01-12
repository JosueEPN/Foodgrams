<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OfflineController;
use App\Http\Controllers\OnlineController;
use App\Http\Controllers\CommentsController;

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
    //Post
    Route::get('/post-show', [PostController::class, 'show'])->name('post.show');
    Route::get('/post-create', [PostController::class, 'create'])->name('post.index');
    Route::post('/post-store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'show'])->name('post.show');
    Route::post('/post/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/{post}/delete', [PostController::class, 'destroy'])->name('post.delete');
    Route::post('/like-post', [PostController::class, 'likeOrDislike'])->name('like-post');
    Route::post('/comment', [PostController::class, 'comment'])->name('comment');
    Route::get('/post/view', [PostController::class, 'view'])->name('post.view');
    Route::get('/post/viewSearch', [SearchUserController::class, 'view'])->name('post.view2');
    //comentarios

    Route::post('/comment/{post}/{user}', [CommentsController::class, 'store'])->name('comment.store');

    //Profile
    Route::get('/profile/{nick_name}', [ProfileController::class,'index'])->name('profile');

    //Chats
    Route::get('/chats', [ChatController::class,'index'])->name('chats');
    Route::get('/user/chat/{nick_name}', [SearchUserController::class,'usersIFollow'])->name('usersIFollow');
    Route::get('/user-chat/{id}', [ChatController::class,'getChat'])->name('get-chat');
    Route::get('/new-chat/{id}', [ChatController::class,'createChatIfNotExists'])->name('get-new-chat');
    Route::post('/chat/send-message', [ChatController::class,'sendMessage'])->name('send-message');
    Route::post('/send-file', [ChatController::class,'sendFile'])->name('send-file');
    Route::get('/direct-message/{id}', [ChatController::class,'directMessage'])->name('direct-message');
   
    //offline and online
    Route::post('/online/{id}', OnlineController::class)->name('online');
    Route::post('/offline/{id}', OfflineController::class)->name('offline');

    //follow
    Route::post('/follow-user', [ProfileController::class,'followUser'])->name('follow-user');
    Route::post('/unfollow-user', [ProfileController::class,'unFollow'])->name('unfollow-user');
    Route::get('/exists-follow/{user_id}', [ProfileController::class,'existsFollow'])->name('exists-follow');
    Route::post('/markAsRead', [ProfileController::class,'markAsRead'])->name('markAsRead');
});
