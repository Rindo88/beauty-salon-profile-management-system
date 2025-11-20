<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $items = Product::latest()->paginate(20);
        $columns = ['name', 'category', 'price_cents', 'discount_percent', 'is_new'];

        return view('admin.crud.index', [
            'title' => 'Products',
            'items' => $items,
            'columns' => $columns,
            'base' => 'admin.products',
        ]);
    }

    public function create()
    {
        $fields = [
            'name' => ['type' => 'text', 'label' => 'Nama'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'image_path' => ['type' => 'text', 'label' => 'Image Path'],
            'description' => ['type' => 'textarea', 'label' => 'Deskripsi'],
            'price_cents' => ['type' => 'number', 'label' => 'Harga (sen)'],
            'discount_percent' => ['type' => 'number', 'label' => 'Diskon (%)'],
            'popularity_score' => ['type' => 'number', 'label' => 'Skor Popularitas'],
            'is_new' => ['type' => 'checkbox', 'label' => 'Produk Baru'],
        ];

        return view('admin.crud.form', [
            'title' => 'Tambah Produk',
            'fields' => $fields,
            'action' => route('admin.products.store'),
            'method' => 'post',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'image_path' => 'nullable|string',
            'description' => 'nullable|string',
            'price_cents' => 'required|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'popularity_score' => 'nullable|integer|min:0',
            'is_new' => 'sometimes|boolean',
        ]);
        $data['is_new'] = (bool) ($data['is_new'] ?? false);
        Product::create($data);

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        $fields = [
            'name' => ['type' => 'text', 'label' => 'Nama'],
            'category' => ['type' => 'text', 'label' => 'Kategori'],
            'image_path' => ['type' => 'text', 'label' => 'Image Path'],
            'description' => ['type' => 'textarea', 'label' => 'Deskripsi'],
            'price_cents' => ['type' => 'number', 'label' => 'Harga (sen)'],
            'discount_percent' => ['type' => 'number', 'label' => 'Diskon (%)'],
            'popularity_score' => ['type' => 'number', 'label' => 'Skor Popularitas'],
            'is_new' => ['type' => 'checkbox', 'label' => 'Produk Baru'],
        ];

        return view('admin.crud.form', [
            'title' => 'Edit Produk',
            'fields' => $fields,
            'action' => route('admin.products.update', $product),
            'method' => 'put',
            'model' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'image_path' => 'nullable|string',
            'description' => 'nullable|string',
            'price_cents' => 'required|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'popularity_score' => 'nullable|integer|min:0',
            'is_new' => 'sometimes|boolean',
        ]);
        $data['is_new'] = (bool) ($data['is_new'] ?? false);
        $product->update($data);

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index');
    }

    public function exportCsv()
    {
        $filename = 'products.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];
        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Kategori', 'Harga', 'Diskon', 'Popularitas']);
            foreach (Product::cursor() as $p) {
                fputcsv($handle, [$p->name, $p->category, $p->price_cents / 100, $p->discount_percent, $p->popularity_score]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $items = Product::all();
        $html = view('admin.exports.products', compact('items'))->render();
        $dompdf = new \Dompdf\Dompdf;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="products.pdf"',
        ]);
    }

    public function exportExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(['Nama', 'Kategori', 'Harga', 'Diskon', 'Popularitas']);
        $row = 2;
        foreach (Product::cursor() as $p) {
            $sheet->fromArray([
                $p->name, $p->category, $p->price_cents / 100, $p->discount_percent, $p->popularity_score,
            ], null, 'A'.$row);
            $row++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $data = ob_get_clean();

        return response($data, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="products.xlsx"',
        ]);
    }
}
