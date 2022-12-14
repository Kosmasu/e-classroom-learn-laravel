<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "kelas";
    protected $primaryKey = "kel_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Absensi() {
      return $this->hasMany(Absensi::class, 'kel_id', 'kel_id');
    }

    public function MataKuliah() {
      return $this->belongsTo(MataKuliah::class, 'matkul_id', 'matkul_id');
    }

    public function Periode() {
      return $this->belongsTo(Periode::class, 'per_id', 'per_id');
    }

    public function Dosen() {
      return $this->belongsTo(Dosen::class, 'dsn_username', 'dsn_username');
    }

    public function Pengumuman() {
      return $this->hasMany(Pengumuman::class, 'kel_id', 'kel_id');
    }

    public function KelasMahasiswa() {
      return $this->hasMany(KelasMahasiswa::class, 'kel_id', 'kel_id');
    }

    public function Module() {
      return $this->hasMany(Module::class, 'kel_id', 'kel_id');
    }
}
