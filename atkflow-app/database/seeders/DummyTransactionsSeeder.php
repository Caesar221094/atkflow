<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyTransactionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Hapus seluruh transaksi sebelumnya (tanpa mengganggu relasi)
            OrderItem::query()->delete();
            Order::query()->delete();
            StockMovement::query()->delete();

            // Reset stok produk ke 0 agar mudah terlihat dari mutasi baru
            Product::query()->update(['stock' => 0]);

            // Ambil beberapa produk untuk contoh transaksi
            $products = Product::orderBy('id')->take(3)->get();
            if ($products->count() < 3) {
                $this->command?->warn('Tidak cukup produk untuk membuat dummy transaksi. Minimal 3 produk.');
                return;
            }

            [$p1, $p2, $p3] = [$products[0], $products[1], $products[2]];

            // Penerimaan stok (stok masuk)
            $inData = [
                [$p1, 100, 'Penerimaan awal gudang untuk ' . $p1->name],
                [$p2, 60, 'Penerimaan awal gudang untuk ' . $p2->name],
                [$p3, 40, 'Penerimaan awal gudang untuk ' . $p3->name],
            ];

            foreach ($inData as [$product, $qty, $note]) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $qty,
                    'note' => $note,
                    'moved_at' => now()->subDays(3),
                ]);

                $product->increment('stock', $qty);
            }

            // Permintaan ATK 1
            $order1 = Order::create([
                'order_number' => 'ORD-DEMO-001',
                'order_date' => now()->subDays(2)->toDateString(),
                'requester_name' => 'Caesar',
                'status' => 'submitted',
                'notes' => 'Permintaan ATK ruang administrasi',
            ]);

            $this->createOrderItemWithMovement($order1, $p1, 10);
            $this->createOrderItemWithMovement($order1, $p2, 5);

            // Permintaan ATK 2
            $order2 = Order::create([
                'order_number' => 'ORD-DEMO-002',
                'order_date' => now()->subDay()->toDateString(),
                'requester_name' => 'Rizki',
                'status' => 'submitted',
                'notes' => 'Permintaan ATK ruang keuangan',
            ]);

            $this->createOrderItemWithMovement($order2, $p1, 20);
            $this->createOrderItemWithMovement($order2, $p3, 10);
        });
    }

    private function createOrderItemWithMovement(Order $order, Product $product, int $quantity): void
    {
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
            'moved_at' => $order->order_date . ' 08:00:00',
        ]);
    }
}
