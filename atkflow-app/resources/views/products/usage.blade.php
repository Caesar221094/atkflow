@extends('layouts.app')

@section('title', 'Riwayat Mutasi Stok Produk')
@section('topbar_title')
    <i class="bi bi-arrow-left-right"></i> Riwayat Mutasi Stok
@endsection
@section('breadcrumb') Dashboard / Produk ATK / Riwayat Mutasi Stok @endsection
@section('page_actions')
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Produk
    </a>
@endsection

@section('content')
    <p class="text-muted small mb-3">
        Halaman ini menampilkan seluruh riwayat penerimaan dan permintaan ATK untuk produk ini, lengkap dengan total stok masuk dan keluar.
    </p>

    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Produk</div>
                    <div class="atk-stat-value">{{ $product->code }} - {{ $product->name }}</div>
                    <div class="text-muted small">Kategori: {{ $product->category?->name }} | Stok saat ini: {{ $product->stock }} {{ $product->unit }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Pemasukan</div>
                    <div class="atk-stat-value">{{ $totalIn }} {{ $product->unit }}</div>
                    <div class="text-muted small">Akumulasi stok masuk</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Pengeluaran</div>
                    <div class="atk-stat-value">{{ $totalOut }} {{ $product->unit }}</div>
                    <div class="text-muted small">Akumulasi stok keluar</div>
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
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ $loop->iteration + ($movements->currentPage() - 1) * $movements->perPage() }}</td>
                        <td>{{ \Carbon\Carbon::parse($movement->moved_at)->format('d/m/Y') }}</td>
                        <td>
                            @if ($movement->type === 'in')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>
                            @if ($movement->type === 'in')
                                +{{ $movement->quantity }}
                            @else
                                -{{ $movement->quantity }}
                            @endif
                            {{ $product->unit }}
                        </td>
                        <td>{{ $movement->note }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada mutasi stok untuk produk ini.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $movements->links() }}
        </div>
    </div>
@endsection
