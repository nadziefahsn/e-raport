<?php

namespace App\Models;
use App\Models\TahunAjaran;
use App\Models\AnggotaKelas;

use Illuminate\Database\Eloquent\Model;

class KondisiTubuh extends Model
{
    protected $fillable = [
        'anggota_kelas_id',
        'tahun_ajaran_id',
        'berat_badan',
        'tinggi_badan',
    ];

    public function anggotaKelas()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
