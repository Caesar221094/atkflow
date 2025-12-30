<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::orderBy('name')->get();

        $query = StockMovement::with('product.category')
            ->where('type', 'in');

        if ($request->filled('date_from')) {
            $query->whereDate('moved_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('moved_at', '<=', $request->input('date_to'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $movements = $query->orderByDesc('moved_at')->paginate(10)->withQueryString();

        $summaryQuery = clone $query;
        $totalTransactions = $summaryQuery->count();
        $totalQuantity = $summaryQuery->sum('quantity');

        $filters = $request->only(['date_from', 'date_to', 'product_id']);

        return view('transactions.stock_in_index', [
            'movements' => $movements,
            'totalTransactions' => $totalTransactions,
            'totalQuantity' => $totalQuantity,
            'products' => $products,
            'filters' => $filters,
        ]);
    }

    public function createGeneral(): View
    {
        $products = Product::orderBy('name')->get();

        return view('transactions.stock_in_create', compact('products'));
    }

    public function create(Product $product): View
    {
        return view('products.stock_in', compact('product'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
            'moved_at' => ['nullable', 'date'],
        ]);

        $quantity = (int) $data['quantity'];

        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $quantity,
            'note' => $data['note'] ?? 'Penambahan stok manual',
            'moved_at' => $data['moved_at'] ?? now(),
        ]);

        $product->increment('stock', $quantity);

        return redirect()
            ->route('products.usage', $product)
            ->with('success', 'Penerimaan ATK berhasil disimpan.');
    }

    public function storeGeneral(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
            'moved_at' => ['nullable', 'date'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $quantity = (int) $data['quantity'];

        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $quantity,
            'note' => $data['note'] ?? 'Penambahan stok manual',
            'moved_at' => $data['moved_at'] ?? now(),
        ]);

        $product->increment('stock', $quantity);

        return redirect()
            ->route('transactions.stock-in.index')
            ->with('success', 'Penerimaan ATK berhasil disimpan.');
    }
}
