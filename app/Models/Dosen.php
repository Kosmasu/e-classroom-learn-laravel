<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = "dosen";
    protected $primaryKey = "dsn_username";
    public $incrementing = false;
    public $timestamps = false;

    public function Kelas() {
      return $this->hasMany(Kelas::class, 'dsn_username', 'dsn_username');
    }
}
