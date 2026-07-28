<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model
{
    use HasFactory;

    protected $fillable = ['kecamatan_id', 'nama_desa'];
    public function kecamatan() { return $this->belongsTo(Kecamatan::class); }
    
}
