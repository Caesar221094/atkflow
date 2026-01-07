<h1 align="center">ATKflow</h1>

<p align="center">
Sistem Manajemen Alat Tulis Kantor (Office Stationery Management System) berbasis Laravel.
</p>

---

## 1. Ringkasan Proyek

ATKflow adalah aplikasi web untuk mengelola persediaan dan penggunaan Alat Tulis Kantor (ATK) di sebuah instansi.

Fokus utama aplikasi:

- Mencatat kategori dan produk ATK secara terstruktur.
- Mengelola stok masuk (stock in) dan stok keluar (stock out).
- Mencatat permintaan/pengeluaran ATK per peminta/unit.
- Menyediakan laporan mutasi dan stok ATK yang rapi.

Repository ini: https://github.com/Caesar221094/atkflow

---

## 2. Fitur Utama

- **Autentikasi Pengguna**
  - Login dengan email & password.
  - Proteksi halaman menggunakan middleware `auth`.

- **Manajemen Kategori ATK**
  - CRUD kategori (nama & deskripsi).
  - Digunakan sebagai master untuk produk ATK.

- **Manajemen Produk ATK**
  - CRUD produk: kategori, kode unik, nama, stok, satuan, harga, deskripsi.
  - Menampilkan daftar produk beserta stok terkini.
  - Halaman riwayat penggunaan per produk (mutasi stok).

- **Transaksi Penerimaan ATK (Stock In)**
  - Input stok masuk secara umum atau langsung dari halaman detail produk.
  - Setiap penerimaan dicatat sebagai mutasi stok `in` dan menambah stok produk.

- **Permintaan/Pemesanan ATK (Stock Out)**
  - Form permintaan dengan banyak item sekaligus.
  - Validasi stok tersedia sebelum permintaan disimpan.
  - Perhitungan otomatis subtotal, total, dan pengurangan stok.
  - Riwayat permintaan dapat difilter dan dilihat per transaksi.

- **Laporan Stok & Mutasi**
  - Laporan stok berdasarkan kategori/produk.
  - Rangkuman mutasi stok masuk/keluar.

Dokumentasi fungsional yang lebih detail ada di `docs/aplikasi-atkflow.md`.

---

## 3. Teknologi yang Digunakan

- **Backend**: PHP 8.2+, Laravel 12.x
- **Database**: MySQL / MariaDB / PostgreSQL (dikustom melalui `.env`)
- **Frontend**: Blade Template, Bootstrap (layout sederhana, siap diganti Sneat)
- **Asset bundler**: Vite (`resources/js/app.js`, `resources/css/app.css`)
- **Dependency management**: Composer (PHP), NPM (frontend)

---

## 4. Persiapan Environment

Pastikan sudah terpasang di komputer Anda:

- PHP 8.2 atau lebih baru
- Composer
- Node.js & NPM
- Database server (MySQL/MariaDB/PostgreSQL)

Clone repository ini (jika belum):

```bash
git clone https://github.com/Caesar221094/atkflow.git
cd atkflow/atkflow-app
```

---

## 5. Cara Instalasi & Menjalankan Aplikasi

Semua perintah dijalankan dari folder `atkflow-app`.

### 5.1. Install dependency PHP

```bash
composer install
```

Jika di Windows muncul masalah antivirus/file-lock pada folder `vendor`, coba sementara exclude folder tersebut lalu jalankan ulang perintah di atas.

### 5.2. Konfigurasi environment

1. Duplikasi file `.env.example` menjadi `.env`.
2. Atur konfigurasi database di `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD, dll).
3. Generate application key:

```bash
php artisan key:generate
```

### 5.3. Migrasi dan seeder database

Jalankan migrasi untuk membuat tabel:

```bash
php artisan migrate
```

Jika tersedia seeder dummy (misalnya `DummyTransactionsSeeder`), Anda bisa menambahkan di `DatabaseSeeder` lalu menjalankan:

```bash
php artisan db:seed
```

### 5.4. Install dependency frontend (opsional untuk pengembangan UI)

```bash
npm install
npm run dev
```

### 5.5. Menjalankan server lokal

```bash
php artisan serve
```

Buka browser dan akses:

```text
http://localhost:8000
```

Halaman utama akan mengarah ke modul Kategori/Produk/Pemesanan ATK (tergantung konfigurasi route).

---

## 6. Struktur Folder Penting

- `app/Models` – Model Eloquent: Category, Product, Order, OrderItem, StockMovement, User.
- `app/Http/Controllers` – Controller untuk kategori, produk, order, laporan, autentikasi, dll.
- `database/migrations` – Skema tabel: users, categories, products, orders, order_items, stock_movements, dll.
- `resources/views` – Blade view (halaman kategori, produk, order, laporan, layout utama).
- `resources/views/layouts/app.blade.php` – Layout utama aplikasi.
- `docs/aplikasi-atkflow.md` – Dokumentasi aplikasi (versi laporan lebih lengkap).

---

## 7. Integrasi Template Sneat (Opsional)

Di dalam folder `public/sneat-1.0.0` sudah terdapat aset template Sneat.

Langkah umum integrasi:

1. Pindahkan/atur aset CSS & JS Sneat ke struktur yang Anda inginkan di `public/`.
2. Ubah `resources/views/layouts/app.blade.php`:
   - Ganti referensi Bootstrap CDN dengan CSS/JS Sneat.
   - Sesuaikan struktur layout (navbar, sidebar, content wrapper).
   - Pastikan `@yield('content')` tetap menjadi area konten halaman.
3. Sesuaikan komponen menu (link ke kategori, produk, pemesanan, laporan) dengan struktur Sneat.

---

## 8. Screenshot & Demo

Untuk keperluan laporan atau portofolio, disarankan menambahkan screenshot pada README atau di folder `docs/`, misalnya:

- Halaman login
- Daftar kategori ATK
- Daftar produk & stok
- Form permintaan/pemesanan ATK
- Laporan stok/mutasi

Jika suatu saat aplikasi di-deploy, tambahkan juga link demo publik di bagian ini.

---

## 9. Lisensi

Proyek ini dibangun di atas Laravel. Untuk informasi lisensi Laravel, silakan lihat https://laravel.com.

Lisensi khusus untuk ATKflow dapat Anda tentukan sendiri (misalnya MIT / private) sesuai kebutuhan.

