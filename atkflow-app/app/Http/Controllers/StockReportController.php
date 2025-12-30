<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockReportController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();
        $allProducts = Product::orderBy('name')->get();

        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('product_id')) {
            $query->where('id', $request->input('product_id'));
        }

        $products = $query->orderBy('name')->paginate(10)->withQueryString();

        $filters = $request->only(['category_id', 'product_id']);

        return view('reports.stock_movements_index', [
            'products' => $products,
            'categories' => $categories,
            'allProducts' => $allProducts,
            'filters' => $filters,
        ]);
    }
}
