<?php
namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanSampah;
use App\Models\KategoriSampah;
use App\Models\Kecamatan;
use App\Models\Desa;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanSampah::where('user_id', auth()->id())->latest()->get();
        return view('masyarakat.laporan.index', compact('laporans'));
    }

    public function create()
    {
        $kategoris = KategoriSampah::where('is_active', true)->get();
        $kecamatans = Kecamatan::all();
        return view('masyarakat.laporan.create', compact('kategoris', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:150',
            'kategori_sampah_id' => 'required|exists:kategori_sampahs,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'desa_id' => 'required|exists:desas,id',
            'deskripsi' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'prioritas_pelapor' => 'required|in:rendah,sedang,tinggi',
            'foto_laporan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto_laporan');
        $laporan = new LaporanSampah($data);
        $laporan->user_id = auth()->id();
        $laporan->kode_laporan = 'SPT-' . date('Ymd') . '-' . rand(1000, 9999);
        
        if ($request->hasFile('foto_laporan')) {
            $file = $request->file('foto_laporan');
            $imageName = 'laporan_' . time() . '_' . uniqid() . '.' . $file->extension();
            
            // Simpan langsung ke public/uploads/laporan_fotos tanpa storage:link
            $destinationPath = public_path('uploads/laporan_fotos');
            $file->move($destinationPath, $imageName);

            $laporan->foto_laporan = ['laporan_fotos/' . $imageName];
        } else {
            $laporan->foto_laporan = [];
        }

        $laporan->status = 'menunggu_verifikasi';
        $laporan->save();

        return redirect()->route('masyarakat.dashboard')->with('success', 'Laporan berhasil dikirim.');
    }

    public function show(LaporanSampah $laporan)
    {
        if ($laporan->user_id !== auth()->id()) abort(403);
        return view('masyarakat.laporan.show', compact('laporan'));
    }
}
