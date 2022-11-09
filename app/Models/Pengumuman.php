<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = "pengumuman";
    protected $primaryKey = "pen_id";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function Kelas() {
      return $this->belongsTo(Kelas::class, 'kel_id', 'kel_id');
    }
}
