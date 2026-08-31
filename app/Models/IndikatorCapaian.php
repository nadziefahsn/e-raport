<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorCapaian extends Model
{
    protected $fillable = [
        'indikator_id',
        'kelas_id',
    ];


    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

}
