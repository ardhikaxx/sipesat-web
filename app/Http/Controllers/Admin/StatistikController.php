<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller {
    public function index() {
        // Tren Laporan 6 Bulan Terakhir
        $enamBulanLalu = Carbon::now()->subMonths(5)->startOfMonth();
        $trenData = LaporanSampah::select(
            DB::raw('COUNT(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
        )
        ->where('created_at', '>=', $enamBulanLalu)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
        
        $labelsTren = [];
        $dataTren = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i)->format('Y-m');
            $labelsTren[] = Carbon::now()->subMonths($i)->translatedFormat('M Y');
            $match = $trenData->firstWhere('bulan', $bulan);
            $dataTren[] = $match ? $match->total : 0;
        }

        // Statistik Berdasarkan Status
        $statusData = LaporanSampah::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        // Wilayah Paling Banyak Laporan (Kecamatan)
        $kecamatanData = LaporanSampah::join('kecamatans', 'laporan_sampahs.kecamatan_id', '=', 'kecamatans.id')
            ->select('kecamatans.nama_kecamatan', DB::raw('count(laporan_sampahs.id) as total'))
            ->groupBy('kecamatans.id', 'kecamatans.nama_kecamatan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('admin.statistik.index', compact('labelsTren', 'dataTren', 'statusData', 'kecamatanData'));
    }
}
