<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderByDesc('published_at')->paginate(10);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $related = BlogPost::where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)->get();
        $comments = BlogComment::where('blog_post_id', $post->id)->where('approved', true)->latest()->get();

        return view('blog.show', compact('post', 'related', 'comments'));
    }
}
