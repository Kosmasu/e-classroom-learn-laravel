<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = "module";
    protected $primaryKey = "mod_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Kelas() {
      return $this->belongsTo(Kelas::class, 'kel_id', 'kel_id');
    }

    public function MahasiswaModule() {
      return $this->hasMany(MahasiswaModule::class, 'mod_id', 'mod_id');
    }
}
