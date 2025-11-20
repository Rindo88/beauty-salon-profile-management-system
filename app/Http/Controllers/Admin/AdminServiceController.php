<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $items = Service::latest()->paginate(20);
        $columns = ['name', 'category', 'duration_minutes', 'price_cents', 'is_popular'];

        return view('admin.crud.index', [
            'title' => 'Services',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.services',
        ]);
    }

    public function create()
    {
        $fields = [
            'name' => ['type' => 'text', 'label' => 'Nama'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'icon_path' => ['type' => 'text', 'label' => 'Icon Path'],
            'description' => ['type' => 'textarea', 'label' => 'Deskripsi'],
            'duration_minutes' => ['type' => 'number', 'label' => 'Durasi (menit)'],
            'price_cents' => ['type' => 'number', 'label' => 'Harga (sen)'],
            'is_popular' => ['type' => 'checkbox', 'label' => 'Populer'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Service',
            'fields' => $fields,
            'action' => route('admin.services.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'icon_path' => 'nullable|string',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'price_cents' => 'required|integer|min:0',
            'is_popular' => 'sometimes|boolean',
        ]);
        $data['is_popular'] = (bool) ($data['is_popular'] ?? false);
        Service::create($data);

        return redirect()->route('admin.services.index');
    }

    public function edit(Service $service)
    {
        $fields = [
            'name' => ['type' => 'text', 'label' => 'Nama'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'icon_path' => ['type' => 'text', 'label' => 'Icon Path'],
            'description' => ['type' => 'textarea', 'label' => 'Deskripsi'],
            'duration_minutes' => ['type' => 'number', 'label' => 'Durasi (menit)'],
            'price_cents' => ['type' => 'number', 'label' => 'Harga (sen)'],
            'is_popular' => ['type' => 'checkbox', 'label' => 'Populer'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Service',
            'fields' => $fields,
            'action' => route('admin.services.update', $service),
            'method' => 'put',
            'model' => $service,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'icon_path' => 'nullable|string',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'price_cents' => 'required|integer|min:0',
            'is_popular' => 'sometimes|boolean',
        ]);
        $data['is_popular'] = (bool) ($data['is_popular'] ?? false);
        $service->update($data);

        return redirect()->route('admin.services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index');
    }
}
