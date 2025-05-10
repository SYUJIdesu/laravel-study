<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// ログインルート
Route::get('/login', [AuthController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest');

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::get('logout', [AuthController::class, 'destroy'])
        ->name('logout');
});
