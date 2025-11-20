<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperatingHour;
use Illuminate\Http\Request;

class AdminOperatingHourController extends Controller
{
    public function index()
    {
        $items = OperatingHour::orderBy('day_of_week')->get();
        $columns = ['day_of_week', 'open_time', 'close_time', 'break_start', 'break_end', 'is_closed'];

        return view('admin.crud.index', [
            'title' => 'Jam Operasional',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.hours',
        ]);
    }

    public function create()
    {
        $fields = [
            'day_of_week' => ['type' => 'number', 'label' => 'Hari (0=Sun)'],
            'open_time' => ['type' => 'time', 'label' => 'Buka'],
            'close_time' => ['type' => 'time', 'label' => 'Tutup'],
            'break_start' => ['type' => 'time', 'label' => 'Istirahat Mulai'],
            'break_end' => ['type' => 'time', 'label' => 'Istirahat Selesai'],
            'is_closed' => ['type' => 'checkbox', 'label' => 'Tutup'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Jam',
            'fields' => $fields,
            'action' => route('admin.hours.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'is_closed' => 'sometimes|boolean',
        ]);
        $data['is_closed'] = (bool) ($data['is_closed'] ?? false);
        OperatingHour::create($data);

        return redirect()->route('admin.hours.index');
    }

    public function edit(OperatingHour $hour)
    {
        $fields = [
            'day_of_week' => ['type' => 'number', 'label' => 'Hari (0=Sun)'],
            'open_time' => ['type' => 'time', 'label' => 'Buka'],
            'close_time' => ['type' => 'time', 'label' => 'Tutup'],
            'break_start' => ['type' => 'time', 'label' => 'Istirahat Mulai'],
            'break_end' => ['type' => 'time', 'label' => 'Istirahat Selesai'],
            'is_closed' => ['type' => 'checkbox', 'label' => 'Tutup'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Jam',
            'fields' => $fields,
            'action' => route('admin.hours.update', $hour),
            'method' => 'put',
            'model' => $hour,
        ]);
    }

    public function update(Request $request, OperatingHour $hour)
    {
        $data = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'is_closed' => 'sometimes|boolean',
        ]);
        $data['is_closed'] = (bool) ($data['is_closed'] ?? false);
        $hour->update($data);

        return redirect()->route('admin.hours.index');
    }

    public function destroy(OperatingHour $hour)
    {
        $hour->delete();

        return redirect()->route('admin.hours.index');
    }
}
