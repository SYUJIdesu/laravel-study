<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * 投稿一覧を表示
     */
    public function index()
    {
        return Inertia::render('Home', [
            'posts' => Post::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * 投稿詳細を表示
     */
    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }
}
