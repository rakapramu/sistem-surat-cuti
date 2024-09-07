<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cuti_id',
        'alasan_cuti',
        'tanggal_mulai_cuti',
        'tanggal_selesai_cuti',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'cuti_id');
    }
}
