@extends('layouts.app')

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
</style>
@endpush

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title mb-1">Data Kategori Aset</h3>
            <p class="text-muted small mb-0">Kelola daftar kategori untuk inventaris aset.</p>
        </div>
        <!-- Tombol Pemicu Modal Tambah (Create) -->
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Kategori
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

    {{-- Tabel Data Kategori --}}
    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $key => $item)
                            <tr>
                                <td class="fw-bold text-secondary">{{ $key + 1 }}</td>
                                <td><span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1" style="border-radius: 6px;">{{ $item->kode_kategori }}</span></td>
                                <td class="fw-semibold text-dark">{{ $item->nama_kategori }}</td>
                                <td class="text-muted">{{ $item->deskripsi ?? '-' }}</td>
                                <td>
                                    @if($item->status == 'Aktif')
                                        <span class="badge bg-success-subtle text-success fw-semibold px-2 py-1" style="border-radius: 6px;">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger fw-semibold px-2 py-1" style="border-radius: 6px;">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit (Memicu Modal Edit) -->
                                    <button type="button" class="btn btn-warning btn-sm text-white me-1" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 6px;">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL EDIT DATA -->
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('kategori.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Kode Kategori</label>
                                                    <input type="text" name="kode_kategori" class="form-control" value="{{ $item->kode_kategori }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kategori</label>
                                                    <input type="text" name="nama_kategori" class="form-control" value="{{ $item->nama_kategori }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Tidak Aktif" {{ $item->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
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
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH DATA (CREATE) -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" name="kode_kategori" class="form-control" placeholder="Contoh: KTG-001" value="{{ old('kode_kategori') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Elektronik" value="{{ old('nama_kategori') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi opsional...">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
            modalTambah.show();
        });
    </script>
    @endpush
@endif
@endsection