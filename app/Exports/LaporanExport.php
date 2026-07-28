<?php

namespace App\Exports;

use App\Models\LaporanSampah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function map($laporan): array
    {
        return [
            $laporan->id,
            $laporan->user ? $laporan->user->name : 'Anonim',
            $laporan->kategoriSampah ? $laporan->kategoriSampah->nama_kategori : '-',
            $laporan->kecamatan ? $laporan->kecamatan->nama_kecamatan : '-',
            $laporan->alamat,
            $laporan->deskripsi,
            strtoupper(str_replace('_', ' ', $laporan->status)),
            $laporan->penugasan && $laporan->penugasan->petugas && $laporan->penugasan->petugas->user 
                ? $laporan->penugasan->petugas->user->name 
                : 'Belum Ditugaskan',
            $laporan->created_at->format('d M Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Pelapor',
            'Kategori',
            'Kecamatan',
            'Alamat Lengkap',
            'Deskripsi',
            'Status',
            'Petugas',
            'Tanggal Dibuat',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
