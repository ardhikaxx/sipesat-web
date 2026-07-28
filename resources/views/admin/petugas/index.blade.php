@extends('layouts.app')
@section('title', 'Manajemen Petugas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Manajemen Petugas</h3>
        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Tambah Petugas</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4" width="5%">No</th>
                            <th width="20%">NIP</th>
                            <th width="30%">Nama Petugas</th>
                            <th width="20%">Wilayah Tugas</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $index => $p)
                        <tr>
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="font-mono text-primary fw-bold">{{ $p->nip }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $p->user->name ?? '-' }}</span>
                                <small class="text-muted">{{ $p->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $p->wilayahTugas->nama_kecamatan ?? '-' }}</td>
                            <td class="text-center">
                                @if($p->status_petugas == 'aktif')
                                    <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus petugas akan menghapus akun user-nya juga. Yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users-slash fs-2 mb-3 d-block"></i>
                                Belum ada data petugas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection