@extends('layouts.app')

@section('title', 'Kategori ATK')
@section('topbar_title')
    <i class="bi bi-folder"></i> Manajemen Kategori ATK
@endsection
@section('breadcrumb') Dashboard / Kategori ATK @endsection
@section('page_actions')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card atk-stat-card border-0">
                <div class="card-body">
                    <div class="atk-stat-label">Total Kategori</div>
                    <div class="atk-stat-value">{{ $categories->total() }}</div>
                    <div class="text-muted small">Kategori alat tulis terdaftar</div>
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
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td class="text-end">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada kategori.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
@endsection
