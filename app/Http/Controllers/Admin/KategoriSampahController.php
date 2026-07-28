<?php
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
