<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanAtasan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'status',
    ];

    public function leaveRequest()
    {
        return $this->belongsTo(PengajuanCuti::class, 'pengajuan_id', 'id');
    }
}
