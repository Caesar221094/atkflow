@extends('layouts.app')

@section('topbar_title', 'Laporan Mutasi Stok')

@section('title')
    Laporan Mutasi Stok ATK
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan / Mutasi Stok</li>
@endsection

@section('content')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? '') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Produk</label>
                    <select name="product_id" id="report_product_id" class="form-select">
                        <option value="">-- Semua Produk --</option>
                        @foreach ($allProducts as $productOption)
                            <option value="{{ $productOption->id }}" @selected(($filters['product_id'] ?? '') == $productOption->id)>
                                {{ $productOption->code }} - {{ $productOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" class="btn btn-primary me-2 mt-3 mt-md-0">Filter</button>
                    <a href="{{ route('reports.stock-movements.index') }}" class="btn btn-outline-secondary mt-3 mt-md-0">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Produk</div>
                    <div class="atk-stat-value">{{ $products->total() }}</div>
                    <div class="text-muted small">Pilih produk untuk melihat riwayat mutasi stok</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Satuan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name }}</td>
                        <td>{{ $product->stock }} {{ $product->unit }}</td>
                        <td>{{ $product->unit }}</td>
                        <td class="text-end">
                            <a href="{{ route('products.usage', $product) }}" class="btn btn-sm btn-info">Lihat Riwayat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada produk.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery) {
                window.jQuery('#report_product_id').select2({
                    placeholder: '-- Semua Produk --',
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endpush
