<?php
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
        
        $rolePetugas = \App\Models\Role::where('name', 'petugas')->first();
        
        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
            'role_id' => $rolePetugas->id
        ]);
        Petugas::create([
            'user_id' => $user->id, 
            'nip' => $request->nip, 
            'wilayah_tugas_kecamatan_id' => $request->wilayah_tugas_kecamatan_id, 
            'status_petugas' => 'aktif'
        ]);
        logActivity('Tambah petugas', 'Master Data', 'Petugas "' . $user->name . '" (NIP ' . $request->nip . ') ditambahkan.');
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
        logActivity('Ubah petugas', 'Master Data', 'Petugas "' . $petuga->user->name . '" diperbarui.');
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas diupdate');
    }
    public function destroy(Petugas $petuga) {
        $nama = $petuga->user->name;
        $petuga->user()->delete();
        $petuga->delete();
        logActivity('Hapus petugas', 'Master Data', 'Petugas "' . $nama . '" dihapus.');
        return redirect()->route('admin.petugas.index')->with('success', 'Petugas dihapus');
    }
}
