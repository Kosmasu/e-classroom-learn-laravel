<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiMahasiswa extends Model
{
    use HasFactory;

    protected $table = "absensimahasiswa";
    protected $primaryKey = "abs_mhs_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Absensi() {
      return $this->belongsTo(Absensi::class, 'abs_id', 'abs_id');
    }

    public function Mahasiswa() {
      return $this->belongsTo(Mahasiswa::class, 'mhs_nrp', 'mhs_nrp');
    }
}
