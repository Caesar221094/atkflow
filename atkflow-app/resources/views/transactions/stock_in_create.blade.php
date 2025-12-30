@extends('layouts.app')

@section('topbar_title', 'Transaksi Pemasukan Stok')

@section('title')
    Buat Pemasukan Stok ATK
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('transactions.stock-in.index') }}">Transaksi / Pemasukan Stok</a></li>
    <li class="breadcrumb-item active">Buat Pemasukan Stok</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Pemasukan Stok</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.stock-in.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                        {{ $product->code }} - {{ $product->name }} (Stok: {{ $product->stock }} {{ $product->unit }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Jumlah Masuk</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" class="form-control @error('quantity') is-invalid @enderror" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="moved_at" class="form-label">Tanggal Pemasukan</label>
                                <input type="date" name="moved_at" id="moved_at" value="{{ old('moved_at', now()->format('Y-m-d')) }}" class="form-control @error('moved_at') is-invalid @enderror">
                                @error('moved_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="note" class="form-label">Keterangan</label>
                                <input type="text" name="note" id="note" value="{{ old('note') }}" class="form-control @error('note') is-invalid @enderror" placeholder="Misal: Penerimaan barang, penyesuaian stok, dll.">
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pemasukan Stok</button>
                        <a href="{{ route('transactions.stock-in.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                    </form>
                </div>
            </div>
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
                window.jQuery('#product_id').select2({
                    placeholder: '-- Pilih Produk --',
                    width: '100%'
                });
            }
        });
    </script>
@endpush
