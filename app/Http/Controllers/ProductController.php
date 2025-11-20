<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }
        if ($sort = $request->query('sort')) {
            if ($sort === 'harga') {
                $query->orderBy('price_cents');
            }
            if ($sort === 'popularitas') {
                $query->orderByDesc('popularity_score');
            }
            if ($sort === 'baru') {
                $query->orderByDesc('is_new');
            }
        }
        $products = $query->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category')->filter();

        return view('products.index', compact('products', 'categories'));
    }
}
