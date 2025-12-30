@extends('layouts.app')

@section('topbar_title', 'Pemasukan Stok')

@section('title')
    Tambah Pemasukan Stok - {{ $product->name }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk ATK</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.usage', $product) }}">Riwayat Mutasi</a></li>
    <li class="breadcrumb-item active">Pemasukan Stok</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Pemasukan Stok</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <input type="text" class="form-control" value="{{ $product->code }} - {{ $product->name }}" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="text" class="form-control" value="{{ $product->stock }} {{ $product->unit }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" class="form-control" value="{{ optional($product->category)->name }}" disabled>
                        </div>
                    </div>

                    <form action="{{ route('products.stock-in.store', $product) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Masuk</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" class="form-control @error('quantity') is-invalid @enderror" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="moved_at" class="form-label">Tanggal Pemasukan</label>
                            <input type="date" name="moved_at" id="moved_at" value="{{ old('moved_at', now()->format('Y-m-d')) }}" class="form-control @error('moved_at') is-invalid @enderror">
                            @error('moved_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Keterangan</label>
                            <input type="text" name="note" id="note" value="{{ old('note') }}" class="form-control @error('note') is-invalid @enderror" placeholder="Misal: Penerimaan barang, penyesuaian stok, dll.">
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('products.usage', $product) }}" class="btn btn-outline-secondary ms-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
