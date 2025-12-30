# Dokumentasi Aplikasi ATKflow

## 2. Deskripsi Singkat Aplikasi

### Gambaran Umum Aplikasi
ATKflow adalah aplikasi web Sistem Manajemen Alat Tulis Kantor (Office Stationery Management System) yang digunakan untuk mengelola data kategori ATK, data produk ATK, stok persediaan, serta transaksi permintaan/pengeluaran ATK dalam sebuah instansi. Aplikasi mencatat setiap penerimaan stok (stock in) dan pengeluaran stok (stock out) sehingga riwayat penggunaan ATK dapat dipantau dengan rapi.

### Masalah yang Diselesaikan
- Mengurangi pencatatan manual ATK yang biasanya menggunakan kertas atau file Excel terpisah.
- Membantu bagian logistik/umum mengontrol ketersediaan stok ATK agar tidak sering habis tanpa terdeteksi.
- Menyediakan histori permintaan ATK per pegawai/unit (siapa peminta, kapan, barang apa, dan berapa banyak).
- Meminimalkan kesalahan pengurangan/penambahan stok karena semua perhitungan dilakukan otomatis oleh sistem.

### Pengguna Aplikasi (Admin/User)
- **Admin / Petugas Logistik ATK**
  - Mengelola master data kategori dan produk ATK.
  - Menginput penerimaan stok ATK (stock in).
  - Mencatat permintaan/pengeluaran ATK dari pegawai.
  - Melihat laporan mutasi stok dan penggunaan per produk.
- **User (Pegawai/Internal Requester)**
  - Secara konsep adalah pihak yang mengajukan permintaan ATK (nama peminta dicatat pada modul pemesanan).
  - Dalam implementasi saat ini, penginputan permintaan dilakukan oleh user yang login (petugas/admin) atas nama peminta yang diisi pada form.

## 3. Fitur Utama

- **Autentikasi Pengguna**
  - Login dengan email dan password.
  - Logout dan proteksi halaman menggunakan middleware `auth`.

- **Manajemen Kategori ATK**
  - CRUD kategori ATK (tambah, ubah, hapus, dan daftar kategori).
  - Penyimpanan nama dan deskripsi kategori.

- **Manajemen Produk ATK**
  - CRUD produk ATK: kategori, kode barang, nama, stok awal, satuan, harga, dan deskripsi.
  - Validasi kode produk unik.
  - Tampilan daftar produk beserta kategori dan stok terkini.
  - Halaman "Riwayat Penggunaan" per produk (usage) yang menampilkan mutasi stok (masuk/keluar) serta total masuk dan total keluar.

- **Transaksi Penerimaan ATK (Stock In)**
  - Input penerimaan stok ATK secara **umum** (memilih produk dari daftar).
  - Input penerimaan stok ATK langsung dari halaman detail/usage produk tertentu.
  - Setiap penerimaan menghasilkan record di tabel mutasi stok (type = `in`) dan otomatis menambah stok produk.

- **Pencatatan Permintaan/Pemesanan ATK (Stock Out)**
  - Form pembuatan permintaan ATK dengan beberapa item sekaligus (multi-item).
  - Setiap item berisi produk dan kuantitas permintaan; sistem memeriksa ketersediaan stok sebelum disimpan.
  - Sistem otomatis menghitung subtotal dan total nilai permintaan (berdasarkan harga satuan produk).
  - Saat permintaan tersimpan, stok produk dikurangi dan tercatat sebagai mutasi stok keluar (type = `out`).
  - Daftar permintaan dapat difilter berdasarkan tanggal dan nama peminta, serta detailnya dapat dilihat per transaksi.

- **Laporan Mutasi Stok / Laporan Stok**
  - Halaman laporan stok berdasarkan produk dan kategori.
  - Filter laporan berdasarkan kategori dan produk tertentu.
  - Menampilkan daftar produk dengan informasi stok dan membantu pemantauan stok yang sering keluar/masuk.

## 4. Struktur Database

Tabel-tabel utama (berdasarkan migration di folder `database/migrations`):

1. **users**
   - Menyimpan data akun pengguna yang dapat login ke sistem.
   - Kolom utama: `id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`.

2. **categories**
   - Menyimpan kategori ATK.
   - Kolom:
     - `id` – primary key.
     - `name` – nama kategori.
     - `description` – deskripsi kategori (opsional).
     - `created_at`, `updated_at`.
   - Relasi: satu kategori memiliki banyak produk (one-to-many ke `products`).

3. **products**
   - Menyimpan master data produk ATK.
   - Kolom:
     - `id`.
     - `category_id` – foreign key ke `categories`.
     - `name` – nama produk.
     - `code` – kode barang unik.
     - `stock` – jumlah stok saat ini.
     - `unit` – satuan (pcs, box, rim, dll).
     - `price` – harga satuan.
     - `description` – deskripsi produk (opsional).
     - `created_at`, `updated_at`.
   - Relasi:
     - `belongsTo` kategori.
     - Digunakan oleh `order_items` dan `stock_movements`.

4. **orders**
   - Menyimpan data header permintaan/pemesanan ATK.
   - Kolom:
     - `id`.
     - `order_number` – nomor permintaan unik (mis. `ORD-YYYYMMDDHHMMSS`).
     - `order_date` – tanggal permintaan.
     - `requester_name` – nama peminta ATK.
     - `status` – status permintaan (`draft`, `submitted`, `approved`, `rejected`, `completed`), saat ini default `submitted` ketika dibuat.
     - `notes` – catatan tambahan (opsional).
     - `created_at`, `updated_at`.
   - Relasi: satu order memiliki banyak `order_items`.

5. **order_items**
   - Menyimpan detail item per permintaan/pemesanan ATK.
   - Kolom:
     - `id`.
     - `order_id` – foreign key ke `orders`.
     - `product_id` – foreign key ke `products`.
     - `quantity` – jumlah yang diminta.
     - `unit_price` – harga satuan saat transaksi.
     - `subtotal` – `unit_price × quantity`.
     - `created_at`, `updated_at`.
   - Relasi:
     - `belongsTo` `orders`.
     - `belongsTo` `products`.

6. **stock_movements**
   - Menyimpan setiap pergerakan stok (mutasi) produk.
   - Kolom:
     - `id`.
     - `product_id` – foreign key ke `products`.
     - `type` – jenis mutasi: `in` (stok masuk) atau `out` (stok keluar).
     - `quantity` – jumlah yang masuk/keluar.
     - `note` – catatan (misalnya "Penambahan stok manual", "Pengeluaran melalui permintaan ORD-…").
     - `moved_at` – timestamp kapan mutasi terjadi.
     - `created_at`, `updated_at`.
   - Relasi: `belongsTo` `products`.
   - Data di tabel ini digunakan untuk:
     - Menghitung riwayat penggunaan per produk (halaman usage).
     - Laporan transaksi penerimaan (stock in).

Selain itu ada tabel standar Laravel seperti `cache`, `jobs`, dan lain-lain untuk kebutuhan framework, tapi fokus domain ATK adalah tabel di atas.

## 5. Teknologi yang Digunakan

- **Bahasa Pemrograman & Framework Backend**
  - PHP 8.2+
  - Laravel 12.x (framework utama untuk routing, MVC, ORM/Eloquent, migrasi database, validasi, dll.)

- **Database**
  - Relational Database (MySQL / MariaDB / PostgreSQL – dikonfigurasi melalui file `.env`).
  - Akses data menggunakan Eloquent ORM (model: `Category`, `Product`, `Order`, `OrderItem`, `StockMovement`, `User`).

- **Frontend / UI**
  - Blade Template Engine (view di `resources/views`).
  - CSS dan komponen dasar berbasis Bootstrap (layout sederhana di `resources/views/layouts/app.blade.php`).
  - Sudah disiapkan untuk integrasi dengan template Sneat (aset berada di `public/sneat-1.0.0`).

- **Build Tools & Dependency Management**
  - Composer untuk dependency PHP.
  - NPM + Vite untuk pengelolaan asset frontend (`resources/js/app.js`, `resources/css/app.css`).

- **Testing & Tools Dev**
  - PHPUnit untuk pengujian (folder `tests`).
  - Laravel Sail/Pail/Pint tersedia sebagai dev-dependency (opsional untuk environment development).

## 6. Screenshot Aplikasi, Link Demo Proyek, Link GitHub

### Screenshot Aplikasi
Disarankan untuk menyertakan screenshot berikut di laporan:
- Halaman login.
- Halaman daftar kategori ATK.
- Halaman daftar produk dan stok.
- Halaman form permintaan ATK (order create).
- Halaman laporan penerimaan stok dan/atau laporan mutasi stok.

Cara ambil:
- Jalankan aplikasi secara lokal (`php artisan serve`).
- Buka di browser `http://localhost:8000`.
- Login, lalu navigasi ke halaman-halaman utama dan ambil screenshot.

### Link Demo Proyek
- Jika sudah di-deploy, isi dengan URL hosting, misalnya:
  - `https://atkflow.nama-domain-anda.com`
- Jika belum di-deploy, dapat ditulis:
  - "Aplikasi saat ini hanya berjalan di lingkungan lokal (localhost)."

### Link GitHub Repository
- Isi dengan URL repository GitHub tempat project ini disimpan, misalnya:
  - `https://github.com/<username-anda>/atkflow`
- Jika repository bersifat private, dapat ditulis:
  - "Repository disimpan secara private di GitHub internal."