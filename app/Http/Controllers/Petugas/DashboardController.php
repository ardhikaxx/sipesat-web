<?php
namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        $petugas = $user->petugas;
        
        if (!$petugas) {
            abort(403, 'Data petugas tidak ditemukan.');
        }

        $tugasBaru = Penugasan::where('petugas_id', $petugas->id)
            ->whereHas('laporanSampah', function($q) {
                $q->where('status', 'diverifikasi');
            })->count();

        $sedangDikerjakan = Penugasan::where('petugas_id', $petugas->id)
            ->whereHas('laporanSampah', function($q) {
                $q->where('status', 'sedang_ditangani');
            })->count();

        $selesai = Penugasan::where('petugas_id', $petugas->id)
            ->whereHas('laporanSampah', function($q) {
                $q->whereIn('status', ['menunggu_validasi_akhir', 'selesai']);
            })->count();

        $tugasTerbaru = Penugasan::with('laporanSampah')
            ->where('petugas_id', $petugas->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view("petugas.dashboard", compact('tugasBaru', 'sedangDikerjakan', 'selesai', 'tugasTerbaru'));
    }
}