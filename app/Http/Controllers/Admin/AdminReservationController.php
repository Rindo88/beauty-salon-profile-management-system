<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $items = Reservation::latest()->paginate(20);
        $columns = ['customer_name', 'date', 'time_slot', 'status'];

        return view('admin.crud.index', [
            'title' => 'Reservasi',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.reservations',
        ]);
    }

    public function edit(Reservation $reservation)
    {
        $fields = [
            'customer_name' => ['type' => 'text', 'label' => 'Nama'],
            'phone' => ['type' => 'text', 'label' => 'Telepon'],
            'email' => ['type' => 'email', 'label' => 'Email'],
            'date' => ['type' => 'date', 'label' => 'Tanggal'],
            'time_slot' => ['type' => 'text', 'label' => 'Waktu'],
            'stylist_preference' => ['type' => 'text', 'label' => 'Stylist'],
            'notes' => ['type' => 'textarea', 'label' => 'Catatan'],
            'status' => ['type' => 'text', 'label' => 'Status'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Reservasi',
            'fields' => $fields,
            'action' => route('admin.reservations.update', $reservation),
            'method' => 'put',
            'model' => $reservation,
        ]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'date' => 'required|date',
            'time_slot' => 'required|string',
            'stylist_preference' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|string',
        ]);
        $reservation->update($data);

        return redirect()->route('admin.reservations.index');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index');
    }

    public function exportCsv()
    {
        $filename = 'reservations.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];
        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Telepon', 'Email', 'Tanggal', 'Waktu', 'Layanan', 'Status']);
            foreach (Reservation::with('service')->cursor() as $r) {
                fputcsv($handle, [
                    $r->customer_name,
                    $r->phone,
                    $r->email,
                    $r->date,
                    $r->time_slot,
                    optional($r->service)->name,
                    $r->status,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $items = Reservation::with('service')->get();
        $html = view('admin.exports.reservations', compact('items'))->render();
        $dompdf = new \Dompdf\Dompdf;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reservations.pdf"',
        ]);
    }

    public function exportExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(['Nama', 'Telepon', 'Email', 'Tanggal', 'Waktu', 'Layanan', 'Status']);
        $row = 2;
        foreach (Reservation::with('service')->cursor() as $r) {
            $sheet->fromArray([
                $r->customer_name, $r->phone, $r->email, $r->date, $r->time_slot, optional($r->service)->name, $r->status,
            ], null, 'A'.$row);
            $row++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $data = ob_get_clean();

        return response($data, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="reservations.xlsx"',
        ]);
    }
}
