@extends('layouts.app')
@section('title', 'Tulis Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Tulis Berita / Edukasi</h3>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required placeholder="Contoh: Sosialisasi Bank Sampah">
                            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan / Berita</option>
                                    <option value="edukasi" {{ old('kategori') == 'edukasi' ? 'selected' : '' }}>Edukasi</option>
                                    <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish (Terbit)</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Konten Artikel <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control @error('konten') is-invalid @enderror" rows="10" required placeholder="Tulis isi berita atau edukasi di sini...">{{ old('konten') }}</textarea>
                            @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane me-2"></i>Simpan & Publikasikan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection