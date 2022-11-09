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

    public function Absensis() {
      return $this->belongsToMany('absensimahasiswa', 'mhs_nrp', 'abs_id');
    }

    public function Kelas() {
      return $this->belongsToMany('kelasmahasiswa', 'mhs_nrp', 'kel_id');
    }
}
