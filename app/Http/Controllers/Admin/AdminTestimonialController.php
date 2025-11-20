<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $items = Testimonial::latest()->paginate(20);
        $columns = ['customer_name', 'rating', 'is_featured'];

        return view('admin.crud.index', [
            'title' => 'Testimonials',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.testimonials',
        ]);
    }

    public function create()
    {
        $fields = [
            'customer_name' => ['type' => 'text', 'label' => 'Nama'],
            'photo_path' => ['type' => 'text', 'label' => 'Foto Path'],
            'rating' => ['type' => 'number', 'label' => 'Rating (1-5)'],
            'content' => ['type' => 'textarea', 'label' => 'Konten'],
            'is_featured' => ['type' => 'checkbox', 'label' => 'Featured'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Testimoni',
            'fields' => $fields,
            'action' => route('admin.testimonials.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'photo_path' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'is_featured' => 'sometimes|boolean',
        ]);
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index');
    }

    public function edit(Testimonial $testimonial)
    {
        $fields = [
            'customer_name' => ['type' => 'text', 'label' => 'Nama'],
            'photo_path' => ['type' => 'text', 'label' => 'Foto Path'],
            'rating' => ['type' => 'number', 'label' => 'Rating (1-5)'],
            'content' => ['type' => 'textarea', 'label' => 'Konten'],
            'is_featured' => ['type' => 'checkbox', 'label' => 'Featured'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Testimoni',
            'fields' => $fields,
            'action' => route('admin.testimonials.update', $testimonial),
            'method' => 'put',
            'model' => $testimonial,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'photo_path' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'is_featured' => 'sometimes|boolean',
        ]);
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index');
    }
}
