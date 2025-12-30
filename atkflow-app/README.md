<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About ATKflow

ATKflow is a simple Office Stationery Management System (Sistem Manajemen Alat Tulis Kantor) built on top of Laravel.

This project currently provides three main modules:

- **Modul Kategori ATK** – CRUD kategori alat tulis (nama, deskripsi).
- **Modul Produk ATK** – CRUD produk ATK (kategori, kode, nama, stok, satuan, harga, deskripsi).
- **Modul Pemesanan ATK** – Pencatatan pemesanan ATK dengan banyak item, perhitungan subtotal dan total, serta pengurangan stok produk secara otomatis.

The UI uses a simple Bootstrap-based layout in `resources/views/layouts/app.blade.php` that is intentionally minimal so you can replace it with your licensed Sneat template.

### How to run locally

1. Install PHP, Composer, and a database (MySQL / MariaDB / PostgreSQL).
2. From the `atkflow-app` directory, install dependencies:

	```bash
	composer install
	```

	> If you see file-lock / antivirus errors on Windows, temporarily exclude the `vendor` folder from real‑time scanning and re-run `composer install`.

3. Create and configure the `.env` file (database, etc.), then generate the app key:

	```bash
	php artisan key:generate
	```

4. Run the database migrations to create ATKflow tables:

	```bash
	php artisan migrate
	```

5. Start the development server:

	```bash
	php artisan serve
	```

6. Open the app in your browser at `http://localhost:8000`. The home page redirects to the Kategori ATK module.

### Integrating Sneat template

1. Place your Sneat assets (CSS, JS, images) into the `public/` directory (for example `public/sneat/css` and `public/sneat/js`).
2. Edit `resources/views/layouts/app.blade.php`:
	- Remove the Bootstrap CDN `<link>` and `<script>` tags.
	- Add the Sneat CSS/JS `<link>` and `<script>` tags according to the Sneat documentation.
	- Keep `@yield('content')` where the page content should appear inside the Sneat layout.
3. Optionally, wrap the navigation and content with Sneat's layout structure (sidebar, header, etc.), reusing the existing links for:
	- Kategori ATK (`route('categories.index')`)
	- Produk ATK (`route('products.index')`)
	- Pemesanan ATK (`route('orders.index')`)

## Laravel

This project is built on top of Laravel. For framework-specific documentation, testing, deployment, and advanced configuration, please refer to the official [Laravel documentation](https://laravel.com/docs).

