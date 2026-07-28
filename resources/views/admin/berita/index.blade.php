@extends('layouts.app')
@section('title', 'Manajemen Berita & Edukasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Berita & Edukasi</h3>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tulis Berita</a>
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
                            <th width="35%">Judul Berita</th>
                            <th width="15%">Kategori</th>
                            <th width="20%">Status</th>
                            <th width="25%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas as $index => $b)
                        <tr>
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $b->judul }}</span>
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $b->created_at->format('d M Y') }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $b->kategori }}</span></td>
                            <td>
                                @if($b->status == 'publish')
                                    <span class="badge bg-success rounded-pill px-3"><i class="fa-solid fa-globe me-1"></i> Published</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3"><i class="fa-solid fa-file-pen me-1"></i> Draft</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.berita.edit', $b->id) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
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
                                <i class="fa-solid fa-newspaper fs-2 mb-3 d-block"></i>
                                Belum ada berita atau artikel edukasi.
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