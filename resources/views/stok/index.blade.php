@extends('layouts.app')

@section('title', 'Data Stok - Sistem Manajemen Aset')

@push('styles')
<style>
    .page-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .page-head h1 {
        font-size: 21px;
        font-weight: 700;
        margin: 0 0 4px;
        letter-spacing: -.2px;
    }

    .page-head p {
        margin: 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    .btn-mono {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--mono-strong);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-mono:hover {
        background: #000;
        color: #fff;
    }

    .table-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16,20,42,.04), 0 8px 20px -14px rgba(16,20,42,.14);
    }

    table.stok-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.stok-table thead th {
        background: var(--mono-strong);
        color: #fff;
        text-align: left;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 600;
        padding: 13px 16px;
    }

    table.stok-table thead th:last-child {
        text-align: right;
    }

    table.stok-table tbody td {
        padding: 13px 16px;
        font-size: 13.5px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        color: var(--text-ink);
    }

    table.stok-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.stok-table tbody tr:hover {
        background: #fafafb;
    }

    .qty-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: "IBM Plex Mono", monospace;
        font-weight: 700;
        font-size: 12.5px;
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--mono-tint);
        color: var(--mono-strong);
    }

    .qty-pill.low {
        background: #f0f0f1;
        border: 1px solid var(--mono-strong);
    }

    .qty-pill.low::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--mono-strong);
    }

    .updated-at {
        color: var(--text-muted);
        font-size: 12.5px;
        font-family: "IBM Plex Mono", monospace;
    }

    .aksi-cell {
        text-align: right;
        white-space: nowrap;
    }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-muted);
        text-decoration: none;
        margin-left: 6px;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-aksi:hover {
        border-color: var(--mono-strong);
        color: var(--mono-strong);
    }

    .btn-aksi.danger:hover {
        background: var(--mono-strong);
        color: #fff;
        border-color: var(--mono-strong);
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 34px;
        color: var(--text-faint);
        margin-bottom: 12px;
        display: block;
    }

    .empty-state p {
        margin: 0;
        font-size: 13.5px;
    }

    .alert-success {
        padding: 12px 16px;
        background: #e6f4ea;
        color: #137333;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 13.5px;
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="page-head">
    <div>
        <h1>Kelola Data Stok Barang</h1>
        <p>Pantau jumlah stok barang dan perbarui datanya di sini.</p>
    </div>
    <!-- Tombol untuk Panggil Modal Tambah -->
    <button type="button" class="btn-mono" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
        <i class="fa-solid fa-plus"></i>
        Tambah Stok
    </button>
</div>

<div class="table-panel">
    <table class="stok-table">
        <thead>
            <tr>
                <th style="width:56px;">No</th>
                <th>Nama Barang</th>
                <th>Jumlah Stok</th>
                <th>Keterangan</th>
                <th>Tanggal Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stok ?? [] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight:600;">{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                    <td>
                        <span class="qty-pill {{ $item->jumlah <= ($item->stok_minimum ?? 10) ? 'low' : '' }}">
                            {{ $item->jumlah }}
                        </span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="updated-at">{{ $item->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                    <td class="aksi-cell">
                        <!-- Tombol Edit Modal -->
                        <button type="button" 
                                class="btn-aksi" 
                                title="Edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditStok{{ $item->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        <!-- Form Hapus -->
                        <form action="{{ route('stok.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data stok ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-aksi danger" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- MODAL EDIT STOK -->
                <div class="modal fade" id="modalEditStok{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditStokLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('stok.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditStokLabel{{ $item->id }}">Edit Data Stok</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="id_barang" class="form-label">Pilih Barang</label>
                                        <select name="id_barang" class="form-select" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($barang as $b)
                                                <option value="{{ $b->id }}" {{ $item->id_barang == $b->id ? 'selected' : '' }}>
                                                    {{ $b->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah Stok</label>
                                        <input type="number" class="form-control" name="jumlah" value="{{ $item->jumlah }}" min="0" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END MODAL EDIT STOK -->

            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fa-solid fa-box-open"></i>
                            <p>Belum ada data stok. Klik "Tambah Stok" untuk menambahkan.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- MODAL TAMBAH STOK -->
<div class="modal fade" id="modalTambahStok" tabindex="-1" aria-labelledby="modalTambahStokLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahStokLabel">Tambah Data Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_barang" class="form-label">Pilih Barang</label>
                        <select name="id_barang" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan jumlah stok" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Stok awal gudang"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL TAMBAH STOK -->

@endsection