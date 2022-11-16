<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primaryKey = "mhs_nrp";
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function Jurusan() {
      return $this->belongsTo(Jurusan::class, 'jur_id', 'jur_id');
    }

    public function AbsensiMahasiswa() {
      return $this->hasMany(AbsensiMahasiswa::class, 'mhs_nrp', 'mhs_nrp');
    }

    public function KelasMahasiswa() {
      return $this->hasMany(KelasMahasiswa::class, 'mhs_nrp', 'mhs_nrp');
    }

    public function MahasiswaModule() {
      return $this->hasMany(MahasiswaModule::class, 'mhs_nrp', 'mhs_nrp');
    }
}
