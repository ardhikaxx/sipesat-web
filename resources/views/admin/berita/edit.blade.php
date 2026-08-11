@extends('layouts.app')
@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Edit Berita / Edukasi</h3>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.berita.update', $beritum->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $beritum->judul) }}" required>
                            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="kegiatan" {{ old('kategori', $beritum->kategori) == 'kegiatan' || old('kategori', $beritum->kategori) == 'Berita' ? 'selected' : '' }}>Kegiatan / Berita</option>
                                    <option value="edukasi" {{ old('kategori', $beritum->kategori) == 'edukasi' || old('kategori', $beritum->kategori) == 'Edukasi' ? 'selected' : '' }}>Edukasi</option>
                                    <option value="pengumuman" {{ old('kategori', $beritum->kategori) == 'pengumuman' || old('kategori', $beritum->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ old('status', $beritum->status) == 'published' ? 'selected' : '' }}>Publish (Terbit)</option>
                                    <option value="draft" {{ old('status', $beritum->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Konten Artikel <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control @error('konten') is-invalid @enderror" rows="10" required>{{ old('konten', $beritum->konten) }}</textarea>
                            @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Thumbnail (Opsional)</label>
                            <div class="mb-2">
                                <img src="{{ $beritum->thumbnail ? Storage::url($beritum->thumbnail) : asset('images/no-image.png') }}" 
                                     onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                                     alt="Thumbnail" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                            @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100"><i class="fa-solid fa-save me-2"></i>Update Berita</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection