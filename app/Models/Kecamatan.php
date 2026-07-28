<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = ['kode_kecamatan', 'nama_kecamatan'];
    public function desas() { return $this->hasMany(Desa::class); }
    
}
