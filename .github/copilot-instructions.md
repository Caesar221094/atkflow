# AI Coding Agent Instructions for ATKFlow

> Status: This repository contains a Laravel 12 application for an Office Stationery Management System (ATKflow). These instructions describe the actual architecture and how agents should work with it.

## 1. Current State & Assumptions
- The workspace root is `ATKFlow`.
- The main Laravel application lives in the `atkflow-app` directory.
- The domain is an office stationery management system (kategori ATK, produk ATK, permintaan/pemesanan, mutasi stok, laporan stok).
- PHP 8.2+ and Laravel 12 are used; do **not** change stack/framework tanpa permintaan eksplisit dari user.

## 2. Project Layout & Architecture
- `atkflow-app/`
  - `app/Http/Controllers/` – application controllers (auth, kategori, produk, orders, stok, laporan).
  - `app/Models/` – Eloquent models (`User`, `Category`, `Product`, `Order`, `OrderItem`, `StockMovement`).
  - `config/` – Laravel configuration (app, database, cache, dll.).
  - `database/migrations/` – database schema (users, categories, products, orders, order_items, stock_movements, dll.).
  - `database/seeders/` – termasuk `DummyTransactionsSeeder` untuk data contoh.
  - `public/` – web root, termasuk folder Sneat template di `public/sneat-1.0.0`.
  - `resources/views/` – Blade views (auth, categories, products, orders, transactions, reports, layouts).
  - `resources/js` dan `resources/css` – asset Vite.
  - `routes/web.php` – route utama web (login, kategori, produk, orders, transaksi stok, laporan stok).
  - `tests/` – kerangka PHPUnit tests bawaan Laravel.
  - `docs/aplikasi-atkflow.md` – dokumentasi fungsional aplikasi (deskripsi, fitur, DB, teknologi).

## 3. Build, Run, and Test Workflows
- Semua perintah dijalankan dari folder `atkflow-app` kecuali dinyatakan lain.
- **Install dependencies**
  - `composer install`
  - `npm install`
- **Konfigurasi env & key**
  - Salin `.env.example` menjadi `.env` jika belum ada.
  - `php artisan key:generate`
  - Atur koneksi database di `.env` lalu jalankan:
    - `php artisan migrate`
- **Menjalankan aplikasi**
  - Development server: `php artisan serve`
  - Asset dev: `npm run dev`
  - Asset build: `npm run build`
- **Testing**
  - `php artisan test` (atau `composer test` jika sudah diset).
- Jangan mengubah command standar Laravel kecuali ada instruksi jelas dari user.

## 4. Patterns and Conventions
- Gunakan pola MVC Laravel yang sudah ada; jangan memindahkan ke arsitektur lain (DDD, hexagonal, dsb.) tanpa persetujuan.
- Ikuti penamaan domain yang sudah ada:
  - "kategori", "produk", "permintaan/pemesanan", "mutasi stok", "laporan stok".
- Relasi utama:
  - `Category` hasMany `Product`.
  - `Order` hasMany `OrderItem`.
  - `Product` hasMany `OrderItem` dan hasMany `StockMovement`.
- Perubahan yang mempengaruhi database harus dilakukan melalui migration baru, **bukan** mengedit migration lama yang sudah ada (kecuali user jelas sedang dalam tahap awal dan belum deploy).

## 5. Collaboration with the User
- Klarifikasi terlebih dahulu ketika user meminta perubahan besar, misalnya:
  - Mengganti stack atau versi framework.
  - Mendesain ulang struktur database atau alur bisnis.
- Sebelum membuat banyak file baru (controller, view, migration, dsb.), ringkas rencana struktur dan minta konfirmasi bila perubahan signifikan.
- Selalu jaga kompatibilitas dengan front-end Blade dan route yang sudah ada (jangan mematahkan route utama tanpa pemberitahuan).

## 6. Adding Features
- Untuk fitur baru di domain ATKflow:
  - Tambah route di `atkflow-app/routes/web.php`.
  - Tambah/ubah controller di `atkflow-app/app/Http/Controllers`.
  - Tambah/ubah model atau relasi di `atkflow-app/app/Models` jika perlu.
  - Tambah view Blade di `atkflow-app/resources/views` mengikuti struktur folder yang sudah ada.
  - Tambah migration baru untuk perubahan struktur database.
- Pertahankan gaya kode Laravel standar (request validation di controller atau Form Request, Eloquent ORM, pagination Laravel, dsb.).

## 7. Updating These Instructions
- Update file ini ketika:
  - Ada perubahan besar pada arsitektur (misalnya penambahan modul besar baru, integrasi API eksternal, atau pemecahan project menjadi beberapa aplikasi).
  - Workflow build/run/test berubah (misalnya penambahan Docker, CI/CD, atau skrip composer baru yang penting).
  - Ada konvensi project khusus yang sebaiknya diketahui agent lain.
- Fokus pada hal yang **spesifik untuk ATKflow**, bukan best practice umum.
