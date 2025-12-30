@extends('layouts.app')

@section('title', 'Detail Permintaan ATK')

@section('content')
    <h1 class="h3 mb-3">Detail Permintaan ATK</h1>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">No. Order</div>
                <div class="col-md-9">{{ $order->order_number }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Tanggal</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Pemesan</div>
                <div class="col-md-9">{{ $order->requester_name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Status</div>
                <div class="col-md-9"><span class="badge bg-secondary text-uppercase">{{ $order->status }}</span></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Catatan</div>
                <div class="col-md-9">{{ $order->notes }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <h5 class="mb-3">Detail Item</h5>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @php($total = 0)
                @foreach ($order->items as $item)
                    @php($total += $item->subtotal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product?->code }} - {{ $item->product?->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>{{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
