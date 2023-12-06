<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('/posts', PostController::class)->only('index', 'show', 'edit', 'update', 'destroy');
    Route::post('/posts/{user}', [PostController::class, 'store'])->name('posts.store');
    Route::resource('/posts.comments', CommentController::class)->only('store');
    Route::resource('/comments', CommentController::class)->only('edit', 'update', 'destroy');

    Route::post('user/{user}/follow', [FollowerController::class, 'follow'])->name('users.follow');
    Route::post('user/{user}/unfollow', [FollowerController::class, 'unfollow'])->name('users.unfollow');

    Route::post('posts/{post}/like', [PostLikeController::class, 'like'])->name('posts.like');
    Route::post('posts/{post}/unlike', [PostLikeController::class, 'unlike'])->name('posts.unlike');

    Route::resource('/friends',  FriendController::class)->only('index');
    Route::get('/friends/friends', [FriendController::class, 'friends'])->name('friends.friends');
    Route::get('/friends/followings', [FriendController::class, 'followings'])->name('friends.followings');
    Route::get('/friends/followers', [FriendController::class, 'followers'])->name('friends.followers');

    Route::resource('/profile', ProfileController::class)->only('index', 'show');

    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
