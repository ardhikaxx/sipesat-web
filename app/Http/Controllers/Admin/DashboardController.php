<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\Petugas;
use App\Models\KategoriSampah;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // Kartu Statistik
        $totalLaporan = LaporanSampah::count();
        $menunggu = LaporanSampah::where('status', 'menunggu_verifikasi')->count();
        $diproses = LaporanSampah::whereIn('status', ['diverifikasi', 'sedang_ditangani'])->count();
        $selesai = LaporanSampah::where('status', 'selesai')->count();
        $ditolak = LaporanSampah::where('status', 'ditolak')->count();
        
        $totalPetugas = Petugas::where('status_petugas', 'aktif')->count();
        
        // Data untuk Grafik Kategori
        $kategoriData = DB::table('laporan_sampahs')
            ->join('kategori_sampahs', 'laporan_sampahs.kategori_sampah_id', '=', 'kategori_sampahs.id')
            ->select('kategori_sampahs.nama_kategori', DB::raw('count(laporan_sampahs.id) as total'))
            ->groupBy('kategori_sampahs.id', 'kategori_sampahs.nama_kategori')
            ->get();
            
        $chartLabels = $kategoriData->pluck('nama_kategori');
        $chartValues = $kategoriData->pluck('total');

        // Data untuk Live Map
        $laporansMap = LaporanSampah::with(['kategoriSampah', 'user'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get(['id', 'kode_laporan', 'judul_laporan', 'alamat_lengkap', 'latitude', 'longitude', 'status', 'kategori_sampah_id', 'user_id', 'created_at']);

        return view("admin.dashboard", compact(
            'totalLaporan', 'menunggu', 'diproses', 'selesai', 'ditolak', 'totalPetugas', 
            'chartLabels', 'chartValues', 'laporansMap'
        ));
    }
}