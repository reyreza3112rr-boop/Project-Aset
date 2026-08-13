@extends('layouts.app')

@section('content')
<div class="container px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-xl">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('ruangan.index') }}" class="btn btn-light btn-sm me-3 text-secondary border">
                            <i class="fas fa-arrow-left"></i>
                        </i></a>
                        <h4 class="mb-0 fw-bold text-dark">Tambah Data Ruangan</h4>
                    </div>

                    <form action="{{ route('ruangan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Kode Ruangan</label>
                            <input type="text" name="kode_ruangan" class="form-control @error('kode_ruangan') is-invalid @enderror" placeholder="Contoh: RNG-001" value="{{ old('kode_ruangan') }}">
                            @error('kode_ruangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" class="form-control @error('nama_ruangan') is-invalid @enderror" placeholder="Contoh: Laboratorium Komputer" value="{{ old('nama_ruangan') }}">
                            @error('nama_ruangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Kapasitas (Orang)</label>
                            <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" placeholder="Contoh: 30" value="{{ old('kapasitas') }}">
                            @error('kapasitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan informasi detail ruangan jika diperlukan...">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('ruangan.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Ruangan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection