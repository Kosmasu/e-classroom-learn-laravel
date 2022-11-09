<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = "matakuliah";
    protected $primaryKey = "matkul_id";
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function Jurusan() {
      return $this->belongsTo(Jurusan::class, 'jur_id', 'jur_id');
    }

    public function Kelas() {
      return $this->hasMany(Kelas::class, 'matkul_id', 'matkul_id');
    }
}
