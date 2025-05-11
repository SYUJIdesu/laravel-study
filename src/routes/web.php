<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

// ログインルート
Route::get('/login', [AuthController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest');

// サブスクリプションのWebhook
Route::post('/subscribe/webhook', [SubscribeController::class, 'webhook'])->name('subscribe.webhook')
    ->withoutMiddleware(ValidateCsrfToken::class);

// 認証が必要なルート
Route::middleware('auth')->group(function () {

    // ログアウト
    Route::get('logout', [AuthController::class, 'destroy'])
        ->name('logout');

    // 投稿一覧
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // プラン一覧
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');

    // サブスク
    Route::post('/subscribe', [SubscribeController::class, 'checkout'])->name('subscribe.checkout');
    Route::get('/subscribe/comp', [SubscribeController::class, 'comp'])->name('subscribe.comp');
    Route::get('/subscribe/customer_portal', [SubscribeController::class, 'customerPortal'])->name('subscribe.customer_portal');

    // ユーザー画面
    Route::get('/user/show', [UserController::class, 'show'])->name('show');

});
