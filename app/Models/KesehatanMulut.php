<?php

namespace App\Models;
use App\Models\AnggotaKelas;

use Illuminate\Database\Eloquent\Model;

class KesehatanMulut extends Model
{
    protected $table = 'muluts';
    
    protected $fillable = [
        'anggota_kelas_id',
        'kesehatan_mulut',
        'keterangan',
    ];

    public function anggotaKelas()
    {
        return $this->belongsTo( AnggotaKelas::class,'anggota_kelas_id');
    }
}
