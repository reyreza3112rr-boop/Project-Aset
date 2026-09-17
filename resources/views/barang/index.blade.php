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
            <h3 class="page-title mb-1">Data Barang / Aset</h3>
            <p class="text-muted small mb-0">Kelola daftar barang dan aset inventaris.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Barang
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
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Ruangan</th>
                            <th>Merek</th>
                            <th>Harga</th>
                            <th>Kondisi</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $key => $item)
                            <tr>
                                <td class="fw-bold text-secondary">{{ $key + 1 }}</td>
                                <td class="fw-semibold text-dark">{{ $item->nama_barang }}</td>
                                <td class="text-muted">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td class="text-muted">{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                                <td class="text-muted">{{ $item->merek ?? '-' }}</td>
                                <td class="text-muted">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $kondisiBadge = [
                                            'baik' => ['label' => 'Baik', 'class' => 'bg-primary'],
                                            'perlu_perbaikan' => ['label' => 'Perlu Perbaikan', 'class' => 'bg-warning text-dark'],
                                            'rusak' => ['label' => 'Rusak', 'class' => 'bg-danger'],
                                        ][$item->kondisi] ?? ['label' => '-', 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $kondisiBadge['class'] }}">{{ $kondisiBadge['label'] }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm text-white me-1" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_barang }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 6px;">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="modalEdit{{ $item->id_barang }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barang.update', $item->id_barang) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Barang</label>
                                                    <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="id_kategori" class="form-select" required>
                                                        <option value="" disabled>-- Pilih Kategori --</option>
                                                        @foreach($kategori as $kat)
                                                            <option value="{{ $kat->id }}" {{ $item->id_kategori == $kat->id ? 'selected' : '' }}>
                                                                {{ $kat->nama_kategori }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ruangan</label>
                                                    <select name="id_ruangan" class="form-select" required>
                                                        <option value="" disabled>-- Pilih Ruangan --</option>
                                                        @foreach($ruangan as $ruang)
                                                            <option value="{{ $ruang->id }}" {{ $item->id_ruangan == $ruang->id ? 'selected' : '' }}>
                                                                {{ $ruang->nama_ruangan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Merek</label>
                                                    <input type="text" name="merek" class="form-control" value="{{ $item->merek }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Harga</label>
                                                    <input type="number" name="harga" class="form-control" value="{{ $item->harga }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kondisi</label>
                                                    <select name="kondisi" class="form-select" required>
                                                        <option value="baik" {{ $item->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                                                        <option value="perlu_perbaikan" {{ $item->kondisi == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                                        <option value="rusak" {{ $item->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
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
                                <td colspan="8" class="text-center text-muted py-4">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop / Proyektor" value="{{ old('nama_barang') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ old('id_kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <select name="id_ruangan" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Ruangan --</option>
                            @foreach($ruangan as $ruang)
                                <option value="{{ $ruang->id }}" {{ old('id_ruangan') == $ruang->id ? 'selected' : '' }}>{{ $ruang->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merek</label>
                        <input type="text" name="merek" class="form-control" placeholder="Contoh: Asus / Epson" value="{{ old('merek') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 5000000" value="{{ old('harga') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="baik" {{ old('kondisi', 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="perlu_perbaikan" {{ old('kondisi') == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                            <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
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