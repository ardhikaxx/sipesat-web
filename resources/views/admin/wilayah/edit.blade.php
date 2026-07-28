@extends('layouts.app')
@section('title', 'Edit Wilayah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Edit Wilayah Kecamatan</h3>
        <a href="{{ route('admin.wilayah.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.wilayah.update', $wilayah->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kode_kecamatan" class="form-control font-mono @error('kode_kecamatan') is-invalid @enderror" value="{{ old('kode_kecamatan', $wilayah->kode_kecamatan) }}" required>
                    @error('kode_kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kecamatan" class="form-control @error('nama_kecamatan') is-invalid @enderror" value="{{ old('nama_kecamatan', $wilayah->nama_kecamatan) }}" required>
                    @error('nama_kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-warning w-100 text-dark fw-bold"><i class="fa-solid fa-save me-2"></i>Update Wilayah</button>
            </form>
        </div>
    </div>
</div>
@endsection