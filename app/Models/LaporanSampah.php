<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanSampah extends Model
{
    use HasFactory;

    protected $fillable = ['kode_laporan', 'user_id', 'kategori_sampah_id', 'kecamatan_id', 'desa_id', 'judul_laporan', 'deskripsi', 'alamat_lengkap', 'latitude', 'longitude', 'foto_laporan', 'prioritas_pelapor', 'prioritas_admin', 'status', 'alasan_penolakan', 'verified_by', 'verified_at', 'completed_at'];
    protected $casts = ['foto_laporan' => 'array', 'verified_at' => 'datetime', 'completed_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function kategoriSampah() { return $this->belongsTo(KategoriSampah::class); }
    public function kecamatan() { return $this->belongsTo(Kecamatan::class); }
    public function desa() { return $this->belongsTo(Desa::class); }
    public function verifiedBy() { return $this->belongsTo(User::class, 'verified_by'); }
    public function penugasan() { return $this->hasOne(Penugasan::class); }
    public function dokumentasiPenanganan() { return $this->hasOne(DokumentasiPenanganan::class); }
    public function laporanStatusHistories() { return $this->hasMany(LaporanStatusHistory::class); }
    public function rating() { return $this->hasOne(Rating::class); }
    
}
