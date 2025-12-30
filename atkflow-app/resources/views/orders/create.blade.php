@extends('layouts.app')

@section('title', 'Buat Permintaan ATK')

@section('content')
    <h1 class="h3 mb-3">Buat Permintaan ATK</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Permintaan</label>
                        <input type="date" name="order_date" class="form-control @error('order_date') is-invalid @enderror" value="{{ old('order_date', now()->toDateString()) }}" required>
                        @error('order_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" name="requester_name" class="form-control @error('requester_name') is-invalid @enderror" value="{{ old('requester_name') }}" required>
                        @error('requester_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Catatan</label>
                        <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes') }}">
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-2">Detail Item</h5>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle" id="items-table">
                        <thead>
                            <tr>
                                <th style="width: 40%">Produk</th>
                                <th style="width: 20%">Qty</th>
                                <th style="width: 20%">Harga</th>
                                <th style="width: 20%">Subtotal</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-outline-primary mb-3" id="add-row">Tambah Baris</button>

                <div class="d-flex justify-content-between align-items-center">
                    <div></div>
                    <div class="text-end">
                        <div class="fw-bold">Total: <span id="grand-total">0</span></div>
                    </div>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">Simpan Pemesanan</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const products = @json($products);

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function recalcRow(row) {
        const productSelect = row.querySelector('select[name$="[product_id]"]');
        const qtyInput = row.querySelector('input[name$="[quantity]"]');
        const priceInput = row.querySelector('.unit-price');
        const subtotalCell = row.querySelector('.subtotal');

        const productId = parseInt(productSelect.value || '0');
        const qty = parseInt(qtyInput.value || '0');
        const product = products.find(p => p.id === productId);
        const price = product ? parseFloat(product.price) : 0;
        priceInput.value = price;
        const subtotal = price * qty;
        subtotalCell.textContent = formatNumber(subtotal);

        recalcTotal();
    }

    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            const productSelect = row.querySelector('select[name$="[product_id]"]');
            const qtyInput = row.querySelector('input[name$="[quantity]"]');
            const productId = parseInt(productSelect.value || '0');
            const qty = parseInt(qtyInput.value || '0');
            const product = products.find(p => p.id === productId);
            const price = product ? parseFloat(product.price) : 0;
            total += price * qty;
        });
        document.getElementById('grand-total').textContent = formatNumber(total);
    }

    function initProductSelect(selectElement) {
        if (window.jQuery && selectElement) {
            window.jQuery(selectElement).select2({
                placeholder: '-- Pilih Produk --',
                width: '100%'
            });
        }
    }

    function addRow(initial = {}) {
        const tbody = document.querySelector('#items-table tbody');
        const index = tbody.children.length;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="items[${index}][product_id]" class="form-select product-select" required>
                    <option value="">-- Pilih Produk --</option>
                    ${products.map(p => `<option value="${p.id}">${p.code} - ${p.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="items[${index}][quantity]" class="form-control" min="1" value="${initial.quantity || 1}" required>
            </td>
            <td>
                <input type="text" class="form-control unit-price" value="0" readonly>
            </td>
            <td class="subtotal">0</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger btn-remove">&times;</button>
            </td>
        `;

        tbody.appendChild(tr);

        const selectEl = tr.querySelector('select');

        initProductSelect(selectEl);

        selectEl.addEventListener('change', () => recalcRow(tr));
        tr.querySelector('input[name$="[quantity]"]').addEventListener('input', () => recalcRow(tr));
        tr.querySelector('.btn-remove').addEventListener('click', () => {
            tr.remove();
            recalcTotal();
        });

        recalcRow(tr);
    }

    document.getElementById('add-row').addEventListener('click', () => addRow());

    // Minimal satu baris awal
    addRow();
</script>
@endpush
