@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Kategori</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.kategori-sampah.update', $kategori_sampah) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Nama Kategori</label><input type="text" name="nama_kategori" class="form-control" value="{{ $kategori_sampah->nama_kategori }}" required></div>
                <div class="mb-3"><label>Deskripsi</label><textarea name="deskripsi" class="form-control">{{ $kategori_sampah->deskripsi }}</textarea></div>
                <div class="mb-3"><label>Aktif</label>
                    <select name="is_active" class="form-control"><option value="1" {{ $kategori_sampah->is_active ? 'selected':'' }}>Ya</option><option value="0" {{ !$kategori_sampah->is_active ? 'selected':'' }}>Tidak</option></select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection