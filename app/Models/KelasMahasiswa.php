<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMahasiswa extends Model
{
    use HasFactory;

    protected $table = "kelasmahasiswa";
    protected $primaryKey = "kel_mhs_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Kelas() {
      return $this->belongsTo(Kelas::class, 'kel_id', 'kel_id');
    }

    public function Mahasiswa() {
      return $this->belongsTo(Mahasiswa::class, 'mhs_nrp', 'mhs_nrp');
    }
}
