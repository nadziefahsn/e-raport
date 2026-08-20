<?php

namespace App\Models;
use App\Models\CapaianPerkembangan;
use App\Models\TahunAjaran;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $fillable = [
        'capaian_perkembangan_id',
        'kode',
        'nama_indikator',
        'jenjang',
        'tahun_ajaran_id',
    ];

    public function capaianPerkembangan()
    {
        return $this->belongsTo(CapaianPerkembangan::class, 'capaian_perkembangan_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
