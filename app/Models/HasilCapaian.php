<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilCapaian extends Model
{
    protected $table = 'hasil_capaian_perkembangans';

    protected $fillable = [
        'anggota_kelas_id',
        'indikator_id',
        'nilai',
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }
}
