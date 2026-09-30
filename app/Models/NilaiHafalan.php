<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiHafalan extends Model
{
    protected $table = 'nilai_hafalans';

    protected $fillable = [
        'anggota_kelas_id',
        'materi_id',
        'nilai'
    ];

    public function anggota_kelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

    public function materi()
    {
        return $this->belongsTo(Indikator::class, 'materi_id');
    }
}
