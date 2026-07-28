@extends('layouts.app')
@section('title', 'Tambah Wilayah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Tambah Wilayah Kecamatan</h3>
        <a href="{{ route('admin.wilayah.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.wilayah.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kode_kecamatan" class="form-control font-mono @error('kode_kecamatan') is-invalid @enderror" value="{{ old('kode_kecamatan') }}" required placeholder="Contoh: KEC-01">
                    @error('kode_kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kecamatan" class="form-control @error('nama_kecamatan') is-invalid @enderror" value="{{ old('nama_kecamatan') }}" required placeholder="Contoh: Magetan">
                    @error('nama_kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-save me-2"></i>Simpan Wilayah</button>
            </form>
        </div>
    </div>
</div>
@endsection