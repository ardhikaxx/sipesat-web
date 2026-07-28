@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kategori Sampah</h6>
            <a href="{{ route('admin.kategori-sampah.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($kategoris as $k)
                    <tr>
                        <td>{{ $k->nama_kategori }}</td><td>{{ $k->deskripsi }}</td>
                        <td>
                            <a href="{{ route('admin.kategori-sampah.edit', $k) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.kategori-sampah.destroy', $k) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection