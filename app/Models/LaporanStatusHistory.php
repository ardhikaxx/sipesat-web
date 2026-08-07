<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_sampah_id', 'status_sebelum', 'status_sesudah', 'keterangan', 'changed_by', 'changed_at'];
    protected $casts = ['changed_at' => 'datetime'];
    public function laporanSampah() { return $this->belongsTo(LaporanSampah::class); }
    public function changedBy() { return $this->belongsTo(User::class, 'changed_by'); }
    public function user() { return $this->belongsTo(User::class, 'changed_by'); }

    public function getStatusBaruAttribute()
    {
        return $this->attributes['status_sesudah'] ?? null;
    }

    public function getStatusAwalAttribute()
    {
        return $this->attributes['status_sebelum'] ?? null;
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status_sesudah'] ?? null;
    }
    
}
