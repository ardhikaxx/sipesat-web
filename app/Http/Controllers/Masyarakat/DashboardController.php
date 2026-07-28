<?php
namespace App\Http\Controllers\Masyarakat;
use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;

class DashboardController extends Controller
{
    public function index() {
        $userId = auth()->id();
        
        $totalLaporan = LaporanSampah::where('user_id', $userId)->count();
        $menunggu = LaporanSampah::where('user_id', $userId)->where('status', 'menunggu_verifikasi')->count();
        $diproses = LaporanSampah::where('user_id', $userId)->whereIn('status', ['diverifikasi', 'sedang_ditangani'])->count();
        $selesai = LaporanSampah::where('user_id', $userId)->where('status', 'selesai')->count();
        
        $laporans = LaporanSampah::where('user_id', $userId)->latest()->take(5)->get();
        
        return view("masyarakat.dashboard", compact('totalLaporan', 'menunggu', 'diproses', 'selesai', 'laporans'));
    }
}