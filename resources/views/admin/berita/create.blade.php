@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Berita</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.berita.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" required></div>
                <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" class="form-control"></div>
                <div class="mb-3"><label>Konten</label><textarea name="konten" class="form-control" rows="5" required></textarea></div>
                <div class="mb-3"><label>Status</label>
                    <select name="status" class="form-control"><option value="draft">Draft</option><option value="publish">Publish</option></select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection