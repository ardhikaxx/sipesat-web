@extends('layouts.app')
@section('title', 'Edit Kategori Sampah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Edit Kategori Sampah</h3>
        <a href="{{ route('admin.kategori-sampah.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.kategori-sampah.update', $kategori_sampah->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori', $kategori_sampah->nama_kategori) }}" required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $kategori_sampah->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Status Aktif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $kategori_sampah->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $kategori_sampah->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-warning w-100 text-dark fw-bold"><i class="fa-solid fa-save me-2"></i>Update Kategori</button>
            </form>
        </div>
    </div>
</div>
@endsection