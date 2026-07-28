@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Kategori</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.kategori-sampah.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label>Nama Kategori</label><input type="text" name="nama_kategori" class="form-control" required></div>
                <div class="mb-3"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
                <div class="mb-3"><label>Aktif</label>
                    <select name="is_active" class="form-control"><option value="1">Ya</option><option value="0">Tidak</option></select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection