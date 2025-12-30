<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->orderBy('name')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:products,code'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk ATK berhasil dibuat.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:products,code,' . $product->id],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk ATK berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk ATK berhasil dihapus.');
    }

    public function usage(Product $product): View
    {
        $movements = StockMovement::where('product_id', $product->id)
            ->orderByDesc('moved_at')
            ->paginate(15);

        $totalIn = StockMovement::where('product_id', $product->id)
            ->where('type', 'in')
            ->sum('quantity');

        $totalOut = StockMovement::where('product_id', $product->id)
            ->where('type', 'out')
            ->sum('quantity');

        return view('products.usage', [
            'product' => $product,
            'movements' => $movements,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
        ]);
    }
}
