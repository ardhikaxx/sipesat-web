<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanSampah;

class LandingController extends Controller
{
    public function index()
    {
        $laporans = LaporanSampah::with(['kategoriSampah', 'kecamatan', 'desa', 'user'])
            ->where('status', 'selesai')
            ->get();
            
        return view('welcome', compact('laporans'));
    }
}
