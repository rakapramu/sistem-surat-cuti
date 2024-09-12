<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public function DivisiHeads()
    {
        return $this->hasMany(DivisiHead::class);
    }
}
