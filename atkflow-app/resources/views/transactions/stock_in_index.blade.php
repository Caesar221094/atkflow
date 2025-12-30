@extends('layouts.app')

@section('topbar_title', 'Transaksi Penerimaan ATK')

@section('title')
    Penerimaan ATK
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Transaksi / Penerimaan ATK</li>
@endsection

@section('page_actions')
    <a href="{{ route('transactions.stock-in.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Penerimaan ATK
    </a>
@endsection

@section('content')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal dari</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Produk</label>
                    <select name="product_id" class="form-select">
                        <option value="">-- Semua Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(($filters['product_id'] ?? '') == $product->id)>
                                {{ $product->code }} - {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary me-2 mt-3 mt-md-0">Filter</button>
                    <a href="{{ route('transactions.stock-in.index') }}" class="btn btn-outline-secondary mt-3 mt-md-0">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Pemasukan</div>
                    <div class="atk-stat-value">{{ $totalTransactions }}</div>
                    <div class="text-muted small">Transaksi stok masuk yang tercatat</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Qty Masuk</div>
                    <div class="atk-stat-value">{{ $totalQuantity }}</div>
                    <div class="text-muted small">Akumulasi jumlah stok masuk</div>
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
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Qty Masuk</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ $loop->iteration + ($movements->currentPage() - 1) * $movements->perPage() }}</td>
                        <td>{{ \Carbon\Carbon::parse($movement->moved_at)->format('d/m/Y') }}</td>
                        <td>{{ $movement->product?->code }} - {{ $movement->product?->name }}</td>
                        <td>{{ $movement->product?->category?->name }}</td>
                        <td>{{ $movement->quantity }} {{ $movement->product?->unit }}</td>
                        <td>{{ $movement->note }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pemasukan stok.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $movements->links() }}
        </div>
    </div>
@endsection
