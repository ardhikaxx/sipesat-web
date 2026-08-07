<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanSampah;

class LandingController extends Controller
{
    public function index()
    {
        $laporans = LaporanSampah::with(['kategoriSampah', 'kecamatan', 'desa', 'user', 'dokumentasiPenanganan'])
            ->where('status', 'selesai')
            ->get();
            
        $beritas = \App\Models\Berita::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
            
        return view('welcome', compact('laporans', 'beritas'));
    }

    public function showBerita($slug)
    {
        $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();
        
        // Update views count
        $berita->increment('views');
        
        return view('berita.show', compact('berita'));
    }
}
