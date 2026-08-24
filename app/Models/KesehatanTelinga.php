<?php

namespace App\Models;
use App\Models\AnggotaKelas;

use Illuminate\Database\Eloquent\Model;

class KesehatanTelinga extends Model
{
    protected $table = 'telingas';

    protected $fillable = [
        'anggota_kelas_id',
        'pendengaran_kanan',
        'pendengaran_kiri',
        'radang_kanan',
        'radang_kiri',
    ];

    public function anggotaKelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }
}
