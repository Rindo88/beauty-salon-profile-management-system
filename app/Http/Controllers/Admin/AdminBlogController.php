<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $items = BlogPost::latest()->paginate(20);
        $columns = ['title', 'category', 'published_at'];

        return view('admin.crud.index', [
            'title' => 'Blog Posts',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.blog',
        ]);
    }

    public function create()
    {
        $fields = [
            'title' => ['type' => 'text', 'label' => 'Judul'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'excerpt' => ['type' => 'textarea', 'label' => 'Ringkasan'],
            'content' => ['type' => 'textarea', 'label' => 'Konten'],
            'cover_image_path' => ['type' => 'text', 'label' => 'Cover Path'],
            'author_name' => ['type' => 'text', 'label' => 'Penulis'],
            'published_at' => ['type' => 'datetime-local', 'label' => 'Terbit'],
            'allow_comments' => ['type' => 'checkbox', 'label' => 'Komentar diizinkan'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Post',
            'fields' => $fields,
            'action' => route('admin.blog.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'cover_image_path' => 'nullable|string',
            'author_name' => 'nullable|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'sometimes|boolean',
        ]);
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        $data['allow_comments'] = (bool) ($data['allow_comments'] ?? false);
        BlogPost::create($data);

        return redirect()->route('admin.blog.index');
    }

    public function edit(BlogPost $blog)
    {
        $fields = [
            'title' => ['type' => 'text', 'label' => 'Judul'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'excerpt' => ['type' => 'textarea', 'label' => 'Ringkasan'],
            'content' => ['type' => 'textarea', 'label' => 'Konten'],
            'cover_image_path' => ['type' => 'text', 'label' => 'Cover Path'],
            'author_name' => ['type' => 'text', 'label' => 'Penulis'],
            'published_at' => ['type' => 'datetime-local', 'label' => 'Terbit'],
            'allow_comments' => ['type' => 'checkbox', 'label' => 'Komentar diizinkan'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Post',
            'fields' => $fields,
            'action' => route('admin.blog.update', $blog),
            'method' => 'put',
            'model' => $blog,
        ]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'cover_image_path' => 'nullable|string',
            'author_name' => 'nullable|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'sometimes|boolean',
        ]);
        $data['allow_comments'] = (bool) ($data['allow_comments'] ?? false);
        $blog->update($data);

        return redirect()->route('admin.blog.index');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blog.index');
    }
}
