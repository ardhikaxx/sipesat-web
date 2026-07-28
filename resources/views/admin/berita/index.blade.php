@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Berita</h6>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($beritas as $b)
                    <tr>
                        <td>{{ $b->judul }}</td><td>{{ $b->kategori }}</td><td>{{ $b->status }}</td>
                        <td>
                            <a href="{{ route('admin.berita.edit', $b) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" class="d-inline">
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