<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin utama untuk login ke sistem
        User::updateOrCreate(
            ['email' => 'admin@atkflow.test'],
            [
                'name' => 'Admin ATKflow',
                'password' => Hash::make('password123'),
            ]
        );

        // Data dummy kategori ATK
        $categories = [
            ['name' => 'Alat Tulis Umum', 'description' => 'Pulpen, pensil, penghapus, penggaris, dan sejenisnya'],
            ['name' => 'Kertas & Buku', 'description' => 'Kertas HVS, buku tulis, post-it, dan map'],
            ['name' => 'Peralatan Arsip', 'description' => 'Ordner, box file, klip, stapler, dan lainnya'],
            ['name' => 'Peralatan Presentasi', 'description' => 'Spidol, papan tulis, pointer, dan aksesoris presentasi'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description']]
            );
        }

        // Data dummy produk ATK
        $categoryByName = Category::all()->keyBy('name');

        $products = [
            [
                'category' => 'Alat Tulis Umum',
                'code' => 'ATK-PEN-BLUE',
                'name' => 'Pulpen Biru Gel',
                'stock' => 200,
                'unit' => 'pcs',
                'price' => 3500,
                'description' => 'Pulpen gel tinta biru untuk kebutuhan harian kantor.',
            ],
            [
                'category' => 'Alat Tulis Umum',
                'code' => 'ATK-PENCIL-2B',
                'name' => 'Pensil 2B',
                'stock' => 150,
                'unit' => 'pcs',
                'price' => 2500,
                'description' => 'Pensil kayu 2B cocok untuk menulis dan mengarsir.',
            ],
            [
                'category' => 'Kertas & Buku',
                'code' => 'ATK-HVS-A4-80',
                'name' => 'Kertas HVS A4 80gsm',
                'stock' => 50,
                'unit' => 'rim',
                'price' => 52000,
                'description' => 'Kertas HVS ukuran A4 dengan ketebalan 80 gsm.',
            ],
            [
                'category' => 'Kertas & Buku',
                'code' => 'ATK-NOTE-A5',
                'name' => 'Buku Catatan A5',
                'stock' => 80,
                'unit' => 'pcs',
                'price' => 12000,
                'description' => 'Buku catatan ukuran A5 dengan garis tipis.',
            ],
            [
                'category' => 'Peralatan Arsip',
                'code' => 'ATK-ORDNER-A4',
                'name' => 'Ordner A4',
                'stock' => 60,
                'unit' => 'pcs',
                'price' => 18000,
                'description' => 'Ordner ukuran A4 untuk penyimpanan dokumen.',
            ],
            [
                'category' => 'Peralatan Presentasi',
                'code' => 'ATK-SPIDOL-BLACK',
                'name' => 'Spidol Whiteboard Hitam',
                'stock' => 100,
                'unit' => 'pcs',
                'price' => 9000,
                'description' => 'Spidol whiteboard warna hitam dengan tinta yang mudah dihapus.',
            ],
        ];

        foreach ($products as $data) {
            $category = $categoryByName->get($data['category']);
            if (! $category) {
                continue;
            }

            Product::updateOrCreate(
                ['code' => $data['code']],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'stock' => $data['stock'],
                    'unit' => $data['unit'],
                    'price' => $data['price'],
                    'description' => $data['description'],
                ]
            );
        }
    }
}
