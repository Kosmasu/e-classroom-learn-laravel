<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    use HasFactory;

    protected $table = "logging";
    protected $primaryKey = "log_id";
    public $incrementing = true;
    public $timestamps = true;
    protected $guarded = [];
}
