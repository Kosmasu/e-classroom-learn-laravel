<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModule extends Model
{
    use HasFactory;

    protected $table = "mahasiswamodule";
    protected $primaryKey = "mhs_mod_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Mahasiswa() {
      return $this->belongsTo(Mahasiswa::class, 'mhs_nrp', 'mhs_nrp');
    }

    public function Module() {
      return $this->belongsTo(Module::class, 'mod_id', 'mod_id');
    }
}
