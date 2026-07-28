@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Wilayah</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.wilayah.update', $wilayah) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Kode Kecamatan</label><input type="text" name="kode_kecamatan" class="form-control" value="{{ $wilayah->kode_kecamatan }}" required></div>
                <div class="mb-3"><label>Nama Kecamatan</label><input type="text" name="nama_kecamatan" class="form-control" value="{{ $wilayah->nama_kecamatan }}" required></div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection