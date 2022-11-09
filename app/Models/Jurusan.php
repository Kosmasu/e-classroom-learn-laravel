<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
  use HasFactory;

  protected $table = "jurusan";
  protected $primaryKey = "jur_id";
  public $incrementing = false;
  public $timestamps = false;

  public function MataKuliah() {
    return $this->hasMany(MataKuliah::class, 'jur_id', 'jur_id');
  }

  public function Mahasiswa() {
    return $this->hasMany(Mahasiswa::class, 'jur_id', 'jur_id');
  }
}
