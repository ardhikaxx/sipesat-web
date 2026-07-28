<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumentasiPenanganan extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_sampah_id', 'petugas_id', 'foto_sebelum', 'foto_sesudah', 'catatan_pekerjaan', 'waktu_mulai', 'waktu_selesai'];
    protected $casts = ['foto_sebelum' => 'array', 'foto_sesudah' => 'array', 'waktu_mulai' => 'datetime', 'waktu_selesai' => 'datetime'];
    public function laporanSampah() { return $this->belongsTo(LaporanSampah::class); }
    public function petugas() { return $this->belongsTo(Petugas::class); }
    
}
