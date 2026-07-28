import os

base_path = r'C:\xampp\htdocs\sipesat'

controllers = {
    'KategoriSampahController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class KategoriSampahController extends Controller
{
    public function index() {
        $kategoris = KategoriSampah::all();
        return view('admin.kategori-sampah.index', compact('kategoris'));
    }
    public function create() {
        return view('admin.kategori-sampah.create');
    }
    public function store(Request $request) {
        $request->validate(['nama_kategori' => 'required']);
        KategoriSampah::create($request->all());
        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Kategori ditambahkan');
    }
    public function edit(KategoriSampah $kategori_sampah) {
        return view('admin.kategori-sampah.edit', compact('kategori_sampah'));
    }
    public function update(Request $request, KategoriSampah $kategori_sampah) {
        $request->validate(['nama_kategori' => 'required']);
        $kategori_sampah->update($request->all());
        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Kategori diupdate');
    }
    public function destroy(KategoriSampah $kategori_sampah) {
        $kategori_sampah->delete();
        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Kategori dihapus');
    }
}
""",
    'WilayahController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index() {
        $kecamatans = Kecamatan::all();
        return view('admin.wilayah.index', compact('kecamatans'));
    }
    public function create() {
        return view('admin.wilayah.create');
    }
    public function store(Request $request) {
        $request->validate(['kode_kecamatan' => 'required', 'nama_kecamatan' => 'required']);
        Kecamatan::create($request->all());
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah ditambahkan');
    }
    public function edit(Kecamatan $wilayah) {
        return view('admin.wilayah.edit', compact('wilayah'));
    }
    public function update(Request $request, Kecamatan $wilayah) {
        $request->validate(['kode_kecamatan' => 'required', 'nama_kecamatan' => 'required']);
        $wilayah->update($request->all());
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah diupdate');
    }
    public function destroy(Kecamatan $wilayah) {
        $wilayah->delete();
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah dihapus');
    }
}
""",
    'PetugasController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index() {
        $petugas = Petugas::with(['user', 'wilayahTugas'])->get();
        return view('admin.petugas.index', compact('petugas'));
    }
    public function create() {
        $kecamatans = Kecamatan::all();
        return view('admin.petugas.create', compact('kecamatans'));
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required',
            'nip' => 'required|unique:petugas', 'wilayah_tugas_kecamatan_id' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => 'petugas'
        ]);
        Petugas::create([
            'user_id' => $user->id, 'nip' => $request->nip, 'wilayah_tugas_kecamatan_id' => $request->wilayah_tugas_kecamatan_id, 'status_petugas' => 'aktif'
        ]);
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas ditambahkan');
    }
    public function edit(Petugas $petuga) {
        $kecamatans = Kecamatan::all();
        return view('admin.petugas.edit', compact('petuga', 'kecamatans'));
    }
    public function update(Request $request, Petugas $petuga) {
        $request->validate([
            'name' => 'required', 'email' => 'required|email|unique:users,email,'.$petuga->user_id,
            'nip' => 'required|unique:petugas,nip,'.$petuga->id, 'wilayah_tugas_kecamatan_id' => 'required'
        ]);
        $petuga->user->update(['name' => $request->name, 'email' => $request->email]);
        if($request->password) {
            $petuga->user->update(['password' => Hash::make($request->password)]);
        }
        $petuga->update([
            'nip' => $request->nip, 'wilayah_tugas_kecamatan_id' => $request->wilayah_tugas_kecamatan_id, 'status_petugas' => $request->status_petugas
        ]);
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas diupdate');
    }
    public function destroy(Petugas $petuga) {
        $petuga->user()->delete();
        $petuga->delete();
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas dihapus');
    }
}
""",
    'BeritaController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index() {
        $beritas = Berita::all();
        return view('admin.berita.index', compact('beritas'));
    }
    public function create() {
        return view('admin.berita.create');
    }
    public function store(Request $request) {
        $request->validate(['judul' => 'required', 'konten' => 'required']);
        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status ?? 'draft',
            'penulis_id' => auth()->id() ?? 1,
        ]);
        return redirect()->route('admin.berita.index')->with('success', 'Berita ditambahkan');
    }
    public function edit(Berita $beritum) {
        return view('admin.berita.edit', compact('beritum'));
    }
    public function update(Request $request, Berita $beritum) {
        $request->validate(['judul' => 'required', 'konten' => 'required']);
        $beritum->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.berita.index')->with('success', 'Berita diupdate');
    }
    public function destroy(Berita $beritum) {
        $beritum->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita dihapus');
    }
}
""",
    'MonitoringController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class MonitoringController extends Controller {
    public function index() { return view('admin.monitoring.index'); }
}
""",
    'StatistikController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class StatistikController extends Controller {
    public function index() { return view('admin.statistik.index'); }
}
""",
    'ActivityLogController': r"""<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ActivityLogController extends Controller {
    public function index() { return view('admin.activity-log.index'); }
}
"""
}

views = {
    'admin/kategori-sampah/index.blade.php': r"""@extends('layouts.app')
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
@endsection""",
    'admin/kategori-sampah/create.blade.php': r"""@extends('layouts.app')
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
@endsection""",
    'admin/kategori-sampah/edit.blade.php': r"""@extends('layouts.app')
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
@endsection""",

    'admin/wilayah/index.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Wilayah (Kecamatan)</h6>
            <a href="{{ route('admin.wilayah.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Kode</th><th>Nama Kecamatan</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($kecamatans as $w)
                    <tr>
                        <td>{{ $w->kode_kecamatan }}</td><td>{{ $w->nama_kecamatan }}</td>
                        <td>
                            <a href="{{ route('admin.wilayah.edit', $w) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.wilayah.destroy', $w) }}" method="POST" class="d-inline">
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
@endsection""",
    'admin/wilayah/create.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Wilayah</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.wilayah.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label>Kode Kecamatan</label><input type="text" name="kode_kecamatan" class="form-control" required></div>
                <div class="mb-3"><label>Nama Kecamatan</label><input type="text" name="nama_kecamatan" class="form-control" required></div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection""",
    'admin/wilayah/edit.blade.php': r"""@extends('layouts.app')
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
@endsection""",

    'admin/petugas/index.blade.php': r"""@extends('layouts.app')
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
@endsection""",
    'admin/petugas/create.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Petugas</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.petugas.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-3"><label>NIP</label><input type="text" name="nip" class="form-control" required></div>
                <div class="mb-3"><label>Wilayah Tugas</label>
                    <select name="wilayah_tugas_kecamatan_id" class="form-control" required>
                        @foreach($kecamatans as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection""",
    'admin/petugas/edit.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Petugas</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.petugas.update', $petuga) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" value="{{ $petuga->user->name ?? '' }}" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $petuga->user->email ?? '' }}" required></div>
                <div class="mb-3"><label>Password (Kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
                <div class="mb-3"><label>NIP</label><input type="text" name="nip" class="form-control" value="{{ $petuga->nip }}" required></div>
                <div class="mb-3"><label>Wilayah Tugas</label>
                    <select name="wilayah_tugas_kecamatan_id" class="form-control" required>
                        @foreach($kecamatans as $k)
                        <option value="{{ $k->id }}" {{ $petuga->wilayah_tugas_kecamatan_id == $k->id ? 'selected':'' }}>{{ $k->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label>Status</label>
                    <select name="status_petugas" class="form-control">
                        <option value="aktif" {{ $petuga->status_petugas == 'aktif' ? 'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ $petuga->status_petugas == 'nonaktif' ? 'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection""",

    'admin/berita/index.blade.php': r"""@extends('layouts.app')
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
@endsection""",
    'admin/berita/create.blade.php': r"""@extends('layouts.app')
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
@endsection""",
    'admin/berita/edit.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Edit Berita</h6></div>
        <div class="card-body">
            <form action="{{ route('admin.berita.update', $beritum) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" value="{{ $beritum->judul }}" required></div>
                <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" class="form-control" value="{{ $beritum->kategori }}"></div>
                <div class="mb-3"><label>Konten</label><textarea name="konten" class="form-control" rows="5" required>{{ $beritum->konten }}</textarea></div>
                <div class="mb-3"><label>Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $beritum->status == 'draft' ? 'selected':'' }}>Draft</option>
                        <option value="publish" {{ $beritum->status == 'publish' ? 'selected':'' }}>Publish</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection""",

    'admin/monitoring/index.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Monitoring</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p>Fitur Monitoring akan ditampilkan di sini.</p>
            <div class="alert alert-info">Silakan integrasikan peta atau laporan langsung.</div>
        </div>
    </div>
</div>
@endsection""",
    'admin/statistik/index.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Statistik</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p>Fitur Statistik & Laporan Kinerja akan ditampilkan di sini.</p>
            <div class="alert alert-info">Chart/Grafik.</div>
        </div>
    </div>
</div>
@endsection""",
    'admin/activity-log/index.blade.php': r"""@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p>Catatan Aktivitas Sistem.</p>
            <table class="table table-bordered">
                <thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th></tr></thead>
                <tbody><tr><td colspan="3" class="text-center">Belum ada data</td></tr></tbody>
            </table>
        </div>
    </div>
</div>
@endsection"""
}

for name, content in controllers.items():
    filepath = os.path.join(base_path, 'app', 'Http', 'Controllers', 'Admin', name + '.php')
    os.makedirs(os.path.dirname(filepath), exist_ok=True)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

for path, content in views.items():
    filepath = os.path.join(base_path, 'resources', 'views', path)
    os.makedirs(os.path.dirname(filepath), exist_ok=True)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

print("Files generated successfully.")
