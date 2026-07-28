@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Berita</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.berita.update', $beritum) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" value="{{ $beritum->judul }}" required></div>
                <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" class="form-control" value="{{ $beritum->kategori }}"></div>
                <div class="mb-3"><label>Konten</label><textarea name="konten" class="form-control" rows="5" required>{{ $beritum->konten }}</textarea></div>
                <div class="mb-3"><label>Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $beritum->status == 'draft' ? 'selected':'' }}>Draft</option>
                        <option value="publish" {{ $beritum->status == 'publish' ? 'selected':'' }}>Publish</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection