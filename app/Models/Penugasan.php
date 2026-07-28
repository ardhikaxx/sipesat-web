<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penugasan extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_sampah_id', 'petugas_id', 'assigned_by', 'catatan_admin', 'assigned_at'];
    protected $casts = ['assigned_at' => 'datetime'];
    public function laporanSampah() { return $this->belongsTo(LaporanSampah::class); }
    public function petugas() { return $this->belongsTo(Petugas::class); }
    public function assignedBy() { return $this->belongsTo(User::class, 'assigned_by'); }
    
}
