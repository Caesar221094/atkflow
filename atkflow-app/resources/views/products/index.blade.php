@extends('layouts.app')

@section('title', 'Produk ATK')
@section('topbar_title')
    <i class="bi bi-box"></i> Master Produk ATK
@endsection
@section('breadcrumb') Dashboard / Produk ATK @endsection
@section('page_actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Produk</div>
                    <div class="atk-stat-value">{{ $products->total() }}</div>
                    <div class="text-muted small">Item ATK yang tersedia</div>
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
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
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
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-end">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada produk.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $products->links() }}
        </div>
    </div>
@endsection
