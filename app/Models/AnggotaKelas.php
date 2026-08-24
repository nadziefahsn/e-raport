<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kehadiran;
use App\Models\KondisiTubuh;
use App\Models\KesehatanMulut;
use App\Models\KebersihanSiswa;
use App\Models\KesehatanTelinga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaKelas extends Model
{
    use HasFactory;

    protected $table = 'anggota_kelas';

    protected $fillable = [
        'nis_id',
        'kelas_id',
    ];

    public function kehadiran()
    {
        return $this->hasOne(Kehadiran::class, 'anggota_kelas_id');
    }

    public function kesehatanMata()
    {
        return $this->hasOne(KesehatanMata::class, 'anggota_kelas_id');
    }


    public function kesehatanGigi()
    {
        return $this->hasOne(KesehatanGigi::class, 'anggota_kelas_id');
    }

    public function kesehatanMulut()
    {
        return $this->hasOne(KesehatanMulut::class, 'anggota_kelas_id');
    }

    public function kebersihanSiswa()
    {
        return $this->hasOne(KebersihanSiswa::class, 'anggota_kelas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_id', 'nis');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function kondisiTubuh()
    {
        return $this->hasOne(KondisiTubuh::class, 'anggota_kelas_id');
    }

    public function kesehatanTelinga()
    {
        return $this->hasOne(KesehatanTelinga::class, 'anggota_kelas_id');
    }
}
