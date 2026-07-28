<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nip', 'wilayah_tugas_kecamatan_id', 'status_petugas'];
    public function user() { return $this->belongsTo(User::class); }
    public function wilayahTugas() { return $this->belongsTo(Kecamatan::class, 'wilayah_tugas_kecamatan_id'); }
    public function penugasans() { return $this->hasMany(Penugasan::class); }
    
}
