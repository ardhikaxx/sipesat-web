<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\DokumentasiPenanganan;
use App\Models\LaporanSampah;
use App\Models\LaporanStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $petugas = auth()->user()->petugas;
        if (!$petugas) {
            abort(403, 'Anda bukan petugas terdaftar.');
        }

        $penugasans = Penugasan::with(['laporanSampah.kategoriSampah', 'laporanSampah.desa'])
            ->where('petugas_id', $petugas->id)
            ->latest('assigned_at')
            ->paginate(15);

        return view('petugas.tugas.index', compact('penugasans'));
    }

    public function show($id)
    {
        $petugas = auth()->user()->petugas;
        $penugasan = Penugasan::with([
            'laporanSampah.user',
            'laporanSampah.kategoriSampah',
            'laporanSampah.kecamatan',
            'laporanSampah.desa',
            'laporanSampah.dokumentasiPenanganan'
        ])
        ->where('petugas_id', $petugas->id)
        ->findOrFail($id);

        return view('petugas.tugas.show', compact('penugasan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'foto_sebelum.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'foto_sesudah.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'catatan_pekerjaan' => 'nullable|string',
            'action' => 'required|in:mulai,selesai'
        ]);

        $petugas = auth()->user()->petugas;
        $penugasan = Penugasan::where('petugas_id', $petugas->id)->findOrFail($id);
        $laporan = $penugasan->laporanSampah;

        $dokumentasi = DokumentasiPenanganan::firstOrNew([
            'laporan_sampah_id' => $laporan->id
        ]);
        $dokumentasi->petugas_id = $petugas->id;

        if ($request->action === 'mulai') {
            if ($request->hasFile('foto_sebelum')) {
                // Hapus foto lama jika ada update
                if (!empty($dokumentasi->foto_sebelum)) {
                    foreach ((array)$dokumentasi->foto_sebelum as $oldFoto) {
                        $oldPath = public_path('uploads/' . $oldFoto);
                        if (\Illuminate\Support\Facades\File::exists($oldPath)) {
                            \Illuminate\Support\Facades\File::delete($oldPath);
                        }
                    }
                }

                $paths = [];
                foreach ($request->file('foto_sebelum') as $file) {
                    $imageName = 'sebelum_' . time() . '_' . uniqid() . '.' . $file->extension();
                    $file->move(public_path('uploads/dokumentasi_sebelum'), $imageName);
                    $paths[] = 'dokumentasi_sebelum/' . $imageName;
                }
                $dokumentasi->foto_sebelum = $paths;
            }
            $dokumentasi->waktu_mulai = now();
            $dokumentasi->save();

            $laporan->update(['status' => 'sedang_ditangani']);
            
            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'diverifikasi',
                'status_sesudah' => 'sedang_ditangani',
                'keterangan' => 'Petugas telah mulai menangani.'
            ]);

            return redirect()->back()->with('success', 'Status diupdate menjadi sedang ditangani.');
        }

        if ($request->action === 'selesai') {
            if ($request->hasFile('foto_sesudah')) {
                // Hapus foto lama jika ada update
                if (!empty($dokumentasi->foto_sesudah)) {
                    foreach ((array)$dokumentasi->foto_sesudah as $oldFoto) {
                        $oldPath = public_path('uploads/' . $oldFoto);
                        if (\Illuminate\Support\Facades\File::exists($oldPath)) {
                            \Illuminate\Support\Facades\File::delete($oldPath);
                        }
                    }
                }

                $paths = [];
                foreach ($request->file('foto_sesudah') as $file) {
                    $imageName = 'sesudah_' . time() . '_' . uniqid() . '.' . $file->extension();
                    $file->move(public_path('uploads/dokumentasi_sesudah'), $imageName);
                    $paths[] = 'dokumentasi_sesudah/' . $imageName;
                }
                $dokumentasi->foto_sesudah = $paths;
            }
            $dokumentasi->waktu_selesai = now();
            $dokumentasi->catatan_pekerjaan = $request->catatan_pekerjaan;
            $dokumentasi->save();

            $laporan->update(['status' => 'menunggu_validasi_akhir']);
            
            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'sedang_ditangani',
                'status_sesudah' => 'menunggu_validasi_akhir',
                'keterangan' => 'Petugas telah selesai menangani.'
            ]);

            return redirect()->back()->with('success', 'Status diupdate menjadi menunggu validasi akhir.');
        }
    }
}
