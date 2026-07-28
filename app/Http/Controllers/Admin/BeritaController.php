<?php
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
