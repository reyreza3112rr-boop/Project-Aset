@extends('layouts.app')

@section('title', 'Data Stok - Sistem Manajemen Aset')

@push('styles')
<style>
    /* Background area utama ala Dashboard */
    .main-content, body {
        background-color: #f3f6f9 !important;
        color: #2b364b !important;
    }

    /* Card Putih dengan Border Halus & Rounded khas Dashboard */
    .content-wrapper .card, .card {
        background: #ffffff !important;
        border: 1px solid #e1e8ed !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
    }

    /* Judul Halaman */
    .page-title {
        color: #1e293b;
        font-weight: 700;
    }

    /* Styling Tabel Bersih & Elegan (garis biru senada sidebar) */
    .content-wrapper .table, .table {
        color: #334155 !important;
        --bs-table-bg: #ffffff;
        --bs-table-border-color: #dbeafe;
    }

    /* Border luar tabel biru tipis */
    .table-responsive {
        border: 1px solid #dbeafe;
        border-radius: 10px;
        overflow: hidden;
    }

    /* Header Tabel dengan Aksen Biru */
    .table thead tr {
        background-color: #eff6ff !important;
        border-bottom: 2px solid #2563eb !important;
    }

    .table thead th {
        color: #1e40af !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-right: 1px solid #dbeafe;
    }

    .table thead th:last-child {
        border-right: none;
    }

    .table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #dbeafe;
        border-right: 1px solid #eff6ff;
    }

    .table tbody td:last-child {
        border-right: none;
    }

    /* Hover efek baris tabel */
    .table-hover tbody tr:hover {
        background-color: #f8fafc !important;
    }

    /* Modal Styling yang Bersih */
    .modal-content {
        background: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 18px 24px;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9 !important;
        padding: 14px 24px;
    }

    .modal-title {
        color: #1e293b;
        font-weight: 600;
    }

    /* Form Input ala Dashboard */
    .form-control, .form-select {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        border-radius: 8px !important;
        padding: 10px 14px;
    }

    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    .form-label {
        color: #475569 !important;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Tombol Utama Biru Cerah */
    .btn-primary {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        border-radius: 8px !important;
        font-weight: 500;
        padding: 8px 16px;
    }

    .btn-primary:hover {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
    }

    /* Pil jumlah stok */
    .qty-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        font-size: 12.5px;
        padding: 4px 12px;
        border-radius: 20px;
        background: #eff6ff;
        color: #1e40af;
    }

    .qty-pill.low {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .qty-pill.low::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title mb-1">Kelola Data Stok Barang</h3>
            <p class="text-muted small mb-0">Pantau jumlah stok barang dan perbarui datanya di sini.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
            + Tambah Stok
        </button>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm text-white" style="background-color: #10b981;" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Pesan Gagal / Error Validasi --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm text-white" style="background-color: #dc2626;" role="alert">
            <strong>Data gagal disimpan:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:56px;">No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Stok</th>
                            <th>Keterangan</th>
                            <th>Tanggal Diperbarui</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stok ?? [] as $item)
                            @php
                                $stokId = $item->id_stok ?? $item->id;
                                $barangId = $item->barang->id_barang ?? $item->barang->id ?? null;
                            @endphp
                            <tr>
                                <td class="fw-bold text-secondary">{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                                <td>
                                    <span class="qty-pill {{ $item->jumlah <= ($item->stok_minimum ?? 10) ? 'low' : '' }}">
                                        {{ $item->jumlah }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $item->keterangan ?? '-' }}</td>
                                <td class="text-muted">{{ $item->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm text-white me-1" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#modalEditStok{{ $stokId }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('stok.destroy', $stokId) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data stok ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 6px;">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL EDIT STOK -->
                            <div class="modal fade" id="modalEditStok{{ $stokId }}" tabindex="-1" aria-labelledby="modalEditStokLabel{{ $stokId }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('stok.update', $stokId) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditStokLabel{{ $stokId }}">Edit Data Stok</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Pilih Barang</label>
                                                    <select name="id_barang" class="form-select" required>
                                                        <option value="">-- Pilih Barang --</option>
                                                        @foreach($barang as $b)
                                                            @php $bId = $b->id_barang ?? $b->id; @endphp
                                                            <option value="{{ $bId }}" {{ $item->id_barang == $bId ? 'selected' : '' }}>
                                                                {{ $b->nama_barang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Stok</label>
                                                    <input type="number" class="form-control" name="jumlah" value="{{ $item->jumlah }}" min="0" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data stok. Klik "Tambah Stok" untuk menambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH STOK -->
<div class="modal fade" id="modalTambahStok" tabindex="-1" aria-labelledby="modalTambahStokLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahStokLabel">Tambah Data Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select name="id_barang" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->id_barang ?? $b->id }}" {{ old('id_barang') == ($b->id_barang ?? $b->id) ? 'selected' : '' }}>{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan jumlah stok" min="0" value="{{ old('jumlah') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Stok awal gudang">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalTambahStok = new bootstrap.Modal(document.getElementById('modalTambahStok'));
            modalTambahStok.show();
        });
    </script>
    @endpush
@endif
@endsection