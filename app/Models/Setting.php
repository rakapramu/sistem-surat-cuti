<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_instansi',
        'alamta_instansi',
        'no_telp',
        'email',
        'laman_web',
        'kode_pos',
        'faks'
    ];
}
