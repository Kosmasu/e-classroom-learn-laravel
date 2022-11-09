<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = "periode";
    protected $primaryKey = "per_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Kelas() {
      return $this->hasMany(Kelas::class, 'per_id', 'per_id');
    }
}
