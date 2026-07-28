<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_sampah_id', 'user_id', 'rating', 'komentar'];
    public function laporanSampah() { return $this->belongsTo(LaporanSampah::class); }
    public function user() { return $this->belongsTo(User::class); }
    
}
