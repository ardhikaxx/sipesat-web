@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Petugas</h6>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Nama</th><th>NIP</th><th>Wilayah Tugas</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($petugas as $p)
                    <tr>
                        <td>{{ $p->user->name ?? '-' }}</td><td>{{ $p->nip }}</td>
                        <td>{{ $p->wilayahTugas->nama_kecamatan ?? '-' }}</td><td>{{ $p->status_petugas }}</td>
                        <td>
                            <a href="{{ route('admin.petugas.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.petugas.destroy', $p) }}" method="POST" class="d-inline">
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