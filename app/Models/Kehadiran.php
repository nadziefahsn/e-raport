<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $fillable = [
        'sakit',
        'izin',
        'tanpa_keterangan',
        'anggota_kelas_id',
        'tahun_ajaran_id',
    ];

    public function anggota_kelas_id()
    {
        return $this->belongsTo(AnggotaKelas::class, 'anggota_kelas_id');
    }

    public function tahun_ajaran_id()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
