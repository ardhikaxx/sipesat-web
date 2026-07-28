<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\Penugasan;
use App\Models\Petugas;
use App\Models\LaporanStatusHistory;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
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

        $kategoris = \App\Models\KategoriSampah::all();
        $kecamatans = \App\Models\Kecamatan::all();
        $petugasList = Petugas::with('user')->where('status_petugas', 'aktif')->get();

        return view('admin.laporan.index', compact('laporans', 'kategoris', 'kecamatans', 'petugasList'));
    }

    public function show($id)
    {
        $laporan = LaporanSampah::with([
            'user', 
            'kategoriSampah', 
            'kecamatan', 
            'desa', 
            'penugasan.petugas.user',
            'dokumentasiPenanganan',
            'laporanStatusHistories.user'
        ])->findOrFail($id);

        $petugasList = Petugas::with('user')->where('status_petugas', 'aktif')->get();

        return view('admin.laporan.show', compact('laporan', 'petugasList'));
    }

    public function verifikasi(Request $request, $id)
    {
        $laporan = LaporanSampah::findOrFail($id);
        
        if ($laporan->status === 'menunggu_verifikasi') {
            $laporan->update([
                'status' => 'diverifikasi',
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'user_id' => auth()->id(),
                'status_awal' => 'menunggu_verifikasi',
                'status_baru' => 'diverifikasi',
                'keterangan' => 'Laporan telah diverifikasi oleh Admin.'
            ]);

            return redirect()->back()->with('success', 'Laporan berhasil diverifikasi.');
        }

        return redirect()->back()->with('error', 'Status laporan tidak valid untuk diverifikasi.');
    }

    public function tugaskan(Request $request, $id)
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'catatan_admin' => 'nullable|string'
        ]);

        $laporan = LaporanSampah::findOrFail($id);
        
        $statusAwal = $laporan->status;
        if (in_array($laporan->status, ['menunggu_verifikasi', 'diverifikasi'])) {
            $laporan->update([
                'status' => 'diverifikasi',
                'verified_by' => $laporan->verified_by ?? auth()->id(),
                'verified_at' => $laporan->verified_at ?? now()
            ]);
            
            if ($statusAwal === 'menunggu_verifikasi') {
                LaporanStatusHistory::create([
                    'laporan_sampah_id' => $laporan->id,
                    'user_id' => auth()->id(),
                    'status_awal' => 'menunggu_verifikasi',
                    'status_baru' => 'diverifikasi',
                    'keterangan' => 'Laporan diverifikasi otomatis saat penugasan.'
                ]);
            }
        }

        Penugasan::updateOrCreate(
            ['laporan_sampah_id' => $laporan->id],
            [
                'petugas_id' => $request->petugas_id,
                'assigned_by' => auth()->id(),
                'catatan_admin' => $request->catatan_admin,
                'assigned_at' => now()
            ]
        );

        LaporanStatusHistory::create([
            'laporan_sampah_id' => $laporan->id,
            'user_id' => auth()->id(),
            'status_awal' => 'diverifikasi',
            'status_baru' => 'diverifikasi',
            'keterangan' => 'Petugas telah ditugaskan.'
        ]);

        return redirect()->back()->with('success', 'Petugas berhasil ditugaskan.');
    }

    public function validasiAkhir(Request $request, $id)
    {
        $laporan = LaporanSampah::findOrFail($id);
        
        if ($laporan->status === 'menunggu_validasi_akhir') {
            $laporan->update([
                'status' => 'selesai',
                'completed_at' => now()
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'user_id' => auth()->id(),
                'status_awal' => 'menunggu_validasi_akhir',
                'status_baru' => 'selesai',
                'keterangan' => 'Penanganan laporan telah divalidasi dan selesai.'
            ]);

            return redirect()->back()->with('success', 'Laporan berhasil divalidasi dan diselesaikan.');
        }

        return redirect()->back()->with('error', 'Status laporan tidak valid untuk validasi akhir.');
    }
}
