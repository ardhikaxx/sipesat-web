@extends('layouts.app')
@section('title', 'Kategori Sampah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Master Kategori Sampah</h3>
        <a href="{{ route('admin.kategori-sampah.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Kategori</a>
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
                            <th width="30%">Nama Kategori</th>
                            <th width="40%">Deskripsi</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $k)
                        <tr>
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="fw-bold text-dark">{{ $k->nama_kategori }}</td>
                            <td class="text-muted">{{ $k->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                @if($k->is_active)
                                    <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.kategori-sampah.edit', $k->id) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.kategori-sampah.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-2 mb-3 d-block"></i>
                                Belum ada data kategori sampah.
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