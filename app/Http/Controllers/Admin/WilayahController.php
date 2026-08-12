<?php
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
        logActivity('Tambah wilayah', 'Master Data', 'Wilayah "' . $request->nama_kecamatan . '" ditambahkan.');
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah ditambahkan');
    }
    public function edit(Kecamatan $wilayah) {
        return view('admin.wilayah.edit', compact('wilayah'));
    }
    public function update(Request $request, Kecamatan $wilayah) {
        $request->validate(['kode_kecamatan' => 'required', 'nama_kecamatan' => 'required']);
        $wilayah->update($request->all());
        logActivity('Ubah wilayah', 'Master Data', 'Wilayah "' . $wilayah->nama_kecamatan . '" diubah.');
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah diupdate');
    }
    public function destroy(Kecamatan $wilayah) {
        logActivity('Hapus wilayah', 'Master Data', 'Wilayah "' . $wilayah->nama_kecamatan . '" dihapus.');
        $wilayah->delete();
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah dihapus');
    }
}
