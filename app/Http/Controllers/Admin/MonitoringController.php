<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\KategoriSampah;
use App\Models\Kecamatan;
use App\Models\Petugas;
use Illuminate\Http\Request;

class MonitoringController extends Controller {
    public function index(Request $request) {
        $query = LaporanSampah::with(['kategoriSampah', 'kecamatan', 'penugasan.petugas.user', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori_sampah_id')) {
            $query->where('kategori_sampah_id', $request->kategori_sampah_id);
        }
        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }
        if ($request->filled('petugas_id')) {
            $query->whereHas('penugasan', function($q) use ($request) {
                $q->where('petugas_id', $request->petugas_id);
            });
        }
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_akhir . ' 23:59:59']);
        }

        $laporans = $query->latest()->paginate(20)->withQueryString();

        $kategoris = KategoriSampah::all();
        $kecamatans = Kecamatan::all();
        $petugasList = Petugas::with('user')->where('status_petugas', 'aktif')->get();

        return view('admin.monitoring.index', compact('laporans', 'kategoris', 'kecamatans', 'petugasList'));
    }
}
