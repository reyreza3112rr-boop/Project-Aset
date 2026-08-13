@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Data Stok Barang</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
            + Tambah Stok
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Stok</th>
                        <th>Keterangan</th>
                        <th>Tanggal Diperbarui</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stok as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <strong>{{ $item->barang->nama_barang ?? 'Barang Tidak Ditemukan' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->jumlah > 5 ? 'success' : 'danger' }} fs-6">
                                    {{ $item->jumlah }} Unit
                                </span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>{{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditStok{{ $item->id_stok }}">
                                    Edit
                                </button>
                                <form action="{{ route('stok.destroy', $item->id_stok) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data stok ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDIT STOK -->
                        <div class="modal fade" id="modalEditStok{{ $item->id_stok }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Stok</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('stok.update', $item->id_stok) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Barang</label>
                                                <select name="id_barang" class="form-select" required>
                                                    <option value="">-- Pilih Barang --</option>
                                                    @foreach($barang as $b)
                                                        <option value="{{ $b->id_barang }}" {{ $item->id_barang == $b->id_barang ? 'selected' : '' }}>
                                                            {{ $b->nama_barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah Stok</label>
                                                <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}" min="0" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control" value="{{ $item->keterangan }}" placeholder="Contoh: Stok Masuk Gudang Utama">
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH STOK -->
<div class="modal fade" id="modalTambahStok" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stok Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select name="id_barang" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->id_barang }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 10" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Stok Awal / Pembelian Tambahan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection