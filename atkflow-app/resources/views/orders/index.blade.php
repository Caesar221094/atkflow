@extends('layouts.app')

@section('title', 'Permintaan ATK')
@section('topbar_title')
    <i class="bi bi-cart"></i> Permintaan ATK
@endsection
@section('breadcrumb') Dashboard / Permintaan ATK @endsection
@section('page_actions')
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Pemesanan
    </a>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Permintaan</div>
                    <div class="atk-stat-value">{{ $orders->total() }}</div>
                    <div class="text-muted small">Permintaan ATK yang tercatat</div>
                </div>
            </div>
        </div>
    </div>
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
                    <label class="form-label">Nama peminta</label>
                    <input type="text" name="requester" class="form-control" placeholder="Cari nama" value="{{ $filters['requester'] ?? '' }}">
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary me-2 mt-3 mt-md-0">Filter</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mt-3 mt-md-0">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                        <td>{{ $order->requester_name }}</td>
                        <td><span class="badge bg-secondary text-uppercase">{{ $order->status }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pemesanan.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $orders->links() }}
        </div>
    </div>
@endsection
