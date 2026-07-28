<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['role_id', 'name', 'nik', 'email', 'password', 'phone', 'address', 'kecamatan_id', 'desa_id', 'photo', 'is_active'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'is_active' => 'boolean']; }
    public function role() { return $this->belongsTo(Role::class); }
    public function kecamatan() { return $this->belongsTo(Kecamatan::class); }
    public function desa() { return $this->belongsTo(Desa::class); }
    public function petugas() { return $this->hasOne(Petugas::class); }
    public function laporanSampahs() { return $this->hasMany(LaporanSampah::class, 'user_id'); }
    
}
