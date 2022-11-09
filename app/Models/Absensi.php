<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absensi";
    protected $primaryKey = "abs_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Kelas() {
      return $this->belongsTo(Kelas::class, 'kel_id', 'kel_id');
    }

    public function Mahasiswas() {
      return $this->belongsToMany('absensimahasiswa', 'abs_id', 'mhs_nrp');
    }
}
