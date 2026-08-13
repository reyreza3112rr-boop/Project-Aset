@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Barang / Aset</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Barang
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
                        <th>ID Kategori</th>
                        <th>ID Ruangan</th>
                        <th>Merek</th>
                        <th>Harga</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $item->nama_barang }}</strong></td>
                            <td>{{ $item->id_kategori ?? '-' }}</td>
                            <td>{{ $item->id_ruangan ?? '-' }}</td>
                            <td>{{ $item->merek ?? '-' }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_barang }}">
                                    Edit
                                </button>
                                <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="modalEdit{{ $item->id_barang }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
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
                                                <label class="form-label">ID Kategori</label>
                                                <input type="number" name="id_kategori" class="form-control" value="{{ $item->id_kategori }}" placeholder="Contoh: 1">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ID Ruangan</label>
                                                <input type="number" name="id_ruangan" class="form-control" value="{{ $item->id_ruangan }}" placeholder="Contoh: 1">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Merek</label>
                                                <input type="text" name="merek" class="form-control" value="{{ $item->merek }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga</label>
                                                <input type="number" name="harga" class="form-control" value="{{ $item->harga }}">
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
                            <td colspan="7" class="text-center text-muted">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
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
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop / Proyektor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Kategori</label>
                        <input type="number" name="id_kategori" class="form-control" placeholder="Contoh: 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Ruangan</label>
                        <input type="number" name="id_ruangan" class="form-control" placeholder="Contoh: 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merek</label>
                        <input type="text" name="merek" class="form-control" placeholder="Contoh: Asus / Epson">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 5000000">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection