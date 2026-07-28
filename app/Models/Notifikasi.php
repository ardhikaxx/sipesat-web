<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'laporan_sampah_id', 'judul', 'pesan', 'tipe', 'is_read', 'read_at'];
    protected $casts = ['is_read' => 'boolean', 'read_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function laporanSampah() { return $this->belongsTo(LaporanSampah::class); }
    
}
