<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
        ]);
        $data['blog_post_id'] = $post->id;
        BlogComment::create($data);

        return redirect()->route('blog.show', $slug);
    }
}
