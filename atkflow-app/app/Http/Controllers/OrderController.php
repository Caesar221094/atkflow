<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('items.product');

        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->input('date_to'));
        }

        if ($request->filled('requester')) {
            $query->where('requester_name', 'like', '%' . $request->input('requester') . '%');
        }

        $orders = $query->orderByDesc('order_date')->paginate(10)->withQueryString();

        $filters = $request->only(['date_from', 'date_to', 'requester']);

        return view('orders.index', compact('orders', 'filters'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();

        return view('orders.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'order_date' => ['required', 'date'],
            'requester_name' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $items = collect($data['items'])
            ->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        /** @var Collection<int, Product> $products */
        $products = Product::whereIn('id', $items->pluck('product_id'))->get();

        foreach ($items as $itemData) {
            $product = $products->firstWhere('id', (int) $itemData['product_id']);
            if (! $product) {
                continue;
            }

            $quantity = (int) $itemData['quantity'];
            if ($quantity > $product->stock) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'items' => 'Stok untuk produk "' . $product->name . '" tidak mencukupi. Stok: ' . $product->stock . ', diminta: ' . $quantity . '.',
                    ]);
            }
        }

        DB::transaction(function () use ($data, $items, $products) {
            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis'),
                'order_date' => $data['order_date'],
                'requester_name' => $data['requester_name'],
                'status' => 'submitted',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($items as $itemData) {
                $product = $products->firstWhere('id', (int) $itemData['product_id']);
                if (! $product) {
                    continue;
                }

                $quantity = (int) $itemData['quantity'];
                $unitPrice = $product->price;
                $subtotal = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'note' => 'Pengeluaran melalui permintaan ' . $order->order_number,
                    'moved_at' => now(),
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Permintaan ATK berhasil dibuat.');
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
