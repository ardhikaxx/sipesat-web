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
        $query = $this->buildFilterQuery($request);

        $laporans = $query->latest()->paginate(10)->withQueryString();

        $kategoris = \App\Models\KategoriSampah::all();
        $kecamatans = \App\Models\Kecamatan::all();
        $petugasList = \App\Models\Petugas::with('user')->where('status_petugas', 'aktif')->get();

        return view('admin.laporan.index', compact('laporans', 'kategoris', 'kecamatans', 'petugasList'));
    }

    public function validasiPekerjaan(Request $request)
    {
        $laporans = LaporanSampah::with(['kategoriSampah', 'kecamatan', 'penugasan.petugas.user', 'user', 'dokumentasiPenanganan'])
            ->whereIn('status', ['menunggu_validasi_akhir', 'sedang_ditangani', 'diverifikasi'])
            ->whereHas('penugasan')
            ->latest()
            ->paginate(10);

        return view('admin.laporan.validasi', compact('laporans'));
    }

    private function buildFilterQuery(Request $request)
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

        return $query;
    }

    public function exportPdf(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $laporans = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact('laporans', 'request'));
        return $pdf->download('laporan-sampah-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport($query), 'laporan-sampah-' . date('Y-m-d') . '.xlsx');
    }

    public function show($id)
    {
        $laporan = LaporanSampah::with([
            'user', 
            'kategoriSampah', 
            'kecamatan', 
            'desa', 
            'penugasan.petugas.user',
            'penugasan.assignedBy',
            'dokumentasiPenanganan',
            'laporanStatusHistories' => function($q) {
                $q->with('user')->orderBy('id', 'desc');
            }
        ])->findOrFail($id);

        $petugasList = Petugas::with('user')
            ->withCount(['penugasans' => function($q) {
                $q->whereHas('laporanSampah', function($q2) {
                    $q2->whereIn('status', ['diverifikasi', 'sedang_ditangani']);
                });
            }])
            ->where('status_petugas', 'aktif')
            ->get();

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
                'changed_by' => auth()->id(),
                'status_sebelum' => 'menunggu_verifikasi',
                'status_sesudah' => 'diverifikasi',
                'keterangan' => 'Laporan telah diverifikasi oleh Admin.'
            ]);

            logActivity('Verifikasi laporan', 'Laporan', 'Laporan "' . $laporan->kode_laporan . '" diverifikasi.', auth()->id());

            return redirect()->back()->with('success', 'Laporan berhasil diverifikasi. Silakan tugaskan petugas lapangan.');
        }

        return redirect()->back()->with('error', 'Status laporan tidak valid untuk diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        $laporan = LaporanSampah::findOrFail($id);
        
        if ($laporan->status === 'menunggu_verifikasi') {
            $laporan->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'menunggu_verifikasi',
                'status_sesudah' => 'ditolak',
                'keterangan' => 'Laporan ditolak. Alasan: ' . $request->alasan_penolakan
            ]);

            logActivity('Tolak laporan', 'Laporan', 'Laporan "' . $laporan->kode_laporan . '" ditolak.', auth()->id());

            return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
        }

        return redirect()->back()->with('error', 'Status laporan tidak valid untuk ditolak.');
    }

    public function tugaskan(Request $request, $id)
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'catatan_admin' => 'nullable|string|max:1000',
            'tenggat_waktu' => 'nullable|date'
        ]);

        $laporan = LaporanSampah::with('penugasan.petugas.user')->findOrFail($id);
        $statusAwal = $laporan->status;
        $isFirstVerification = false;
        
        if (in_array($laporan->status, ['menunggu_verifikasi', 'diverifikasi'])) {
            if ($statusAwal === 'menunggu_verifikasi') {
                $isFirstVerification = true;
            }

            $laporan->update([
                'status' => 'diverifikasi',
                'verified_by' => $laporan->verified_by ?? auth()->id(),
                'verified_at' => $laporan->verified_at ?? now()
            ]);
            
            if ($isFirstVerification) {
                LaporanStatusHistory::create([
                    'laporan_sampah_id' => $laporan->id,
                    'changed_by' => auth()->id(),
                    'status_sebelum' => 'menunggu_verifikasi',
                    'status_sesudah' => 'diverifikasi',
                    'keterangan' => 'Laporan diverifikasi oleh Admin.'
                ]);
            }
        }

        $petugas = Petugas::with('user')->findOrFail($request->petugas_id);
        $namaPetugas = $petugas->user->name ?? 'Petugas';
        $isReassign = ($laporan->penugasan !== null);

        Penugasan::updateOrCreate(
            ['laporan_sampah_id' => $laporan->id],
            [
                'petugas_id' => $request->petugas_id,
                'assigned_by' => auth()->id(),
                'catatan_admin' => $request->catatan_admin,
                'tenggat_waktu' => $request->tenggat_waktu,
                'assigned_at' => now()
            ]
        );

        $keteranganHistory = $isReassign
            ? 'Penugasan diperbarui ke petugas ' . $namaPetugas . ' oleh Admin.'
            : 'Petugas ' . $namaPetugas . ' telah ditugaskan untuk menangani laporan.';

        LaporanStatusHistory::create([
            'laporan_sampah_id' => $laporan->id,
            'changed_by' => auth()->id(),
            'status_sebelum' => 'diverifikasi',
            'status_sesudah' => 'diverifikasi',
            'keterangan' => $keteranganHistory
        ]);

        logActivity('Tugaskan petugas', 'Penugasan', 'Laporan "' . $laporan->kode_laporan . '" ditugaskan ke petugas ' . $namaPetugas . '.', auth()->id());

        $successMsg = $isReassign
            ? 'Penugasan berhasil diperbarui. Petugas saat ini: ' . $namaPetugas . '.'
            : 'Petugas ' . $namaPetugas . ' berhasil ditugaskan ke laporan ini.';

        return redirect()->route('admin.laporan.show', $laporan->id)->with('success', $successMsg);
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
                'changed_by' => auth()->id(),
                'status_sebelum' => 'menunggu_validasi_akhir',
                'status_sesudah' => 'selesai',
                'keterangan' => 'Penanganan laporan telah divalidasi dan selesai.'
            ]);

            logActivity('Validasi akhir laporan', 'Laporan', 'Laporan "' . $laporan->kode_laporan . '" divalidasi selesai.', auth()->id());

            return redirect()->back()->with('success', 'Laporan berhasil divalidasi dan diselesaikan.');
        }

        return redirect()->back()->with('error', 'Status laporan tidak valid untuk validasi akhir.');
    }
}
