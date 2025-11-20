<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $items = GalleryPhoto::orderBy('sort_order')->paginate(30);
        $columns = ['category', 'image_path', 'alt_text', 'sort_order'];

        return view('admin.crud.index', [
            'title' => 'Galeri',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.gallery',
        ]);
    }

    public function create()
    {
        $fields = [
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'image_path' => ['type' => 'text', 'label' => 'Image Path'],
            'alt_text' => ['type' => 'text', 'label' => 'Alt'],
            'caption' => ['type' => 'text', 'label' => 'Caption'],
            'sort_order' => ['type' => 'number', 'label' => 'Urutan'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Foto',
            'fields' => $fields,
            'action' => route('admin.gallery.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'image_path' => 'required|string',
            'alt_text' => 'nullable|string',
            'caption' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
        GalleryPhoto::create($data);

        return redirect()->route('admin.gallery.index');
    }

    public function edit(GalleryPhoto $gallery)
    {
        $fields = [
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'image_path' => ['type' => 'text', 'label' => 'Image Path'],
            'alt_text' => ['type' => 'text', 'label' => 'Alt'],
            'caption' => ['type' => 'text', 'label' => 'Caption'],
            'sort_order' => ['type' => 'number', 'label' => 'Urutan'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Foto',
            'fields' => $fields,
            'action' => route('admin.gallery.update', $gallery),
            'method' => 'put',
            'model' => $gallery,
        ]);
    }

    public function update(Request $request, GalleryPhoto $gallery)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'image_path' => 'required|string',
            'alt_text' => 'nullable|string',
            'caption' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
        $gallery->update($data);

        return redirect()->route('admin.gallery.index');
    }

    public function destroy(GalleryPhoto $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index');
    }
}
