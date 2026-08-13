@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">Manajemen Ruangan</h1>
            <p class="text-muted mb-0">Kelola data ruangan, kapasitas, dan informasi aset ruangan.</p>
        </div>
        <a href="{{ route('ruangan.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Ruangan
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Table Container -->
    <div class="card border-0 shadow-sm rounded-xl">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Kode Ruangan</th>
                            <th class="py-3">Nama Ruangan</th>
                            <th class="py-3">Kapasitas</th>
                            <th class="py-3">Keterangan</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangans as $index => $ruangan)
                        <tr>
                            <td class="fw-semibold text-secondary">{{ $index + 1 }}</td>
                            <td><span class="badge bg-light text-dark border px-2 py-1 font-monospace">{{ $ruangan->kode_ruangan }}</span></td>
                            <td class="fw-bold text-dark">{{ $ruangan->nama_ruangan }}</td>
                            <td>
                                <span class="text-secondary"><i class="fas fa-users me-1 text-muted"></i> {{ $ruangan->kapasitas }} Orang</span>
                            </td>
                            <td class="text-muted text-truncate" style="max-width: 200px;">{{ $ruangan->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="btn btn-sm btn-outline-warning text-dark px-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('ruangan.destroy', $ruangan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ruangan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2 rounded-end" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 text-black-50"></i>
                                <p class="mb-0">Belum ada data ruangan yang tersedia.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection