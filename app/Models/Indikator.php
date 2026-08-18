<?php

namespace App\Models;
use App\Models\CapaianPerkembangan;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $fillable = [
        'capaian_perkembangan_id',
        'kode',
        'nama_indikator',
    ];

    public function capaianPerkembangan()
    {
        return $this->belongsTo(CapaianPerkembangan::class, 'capaian_perkembangan_id');
    }
}
