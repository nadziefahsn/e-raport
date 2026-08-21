<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesehatanGigi extends Model
{
    protected $fillable = [
        'anggota_kelas_id',
        'kesehatan_gigi',
        'keterangan',
    ];

    public function anggotaKelas()
    {
        return $this->belongsTo( AnggotaKelas::class,'anggota_kelas_id');
    }
}
