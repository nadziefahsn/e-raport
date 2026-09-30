<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriHafalan extends Model
{
    protected $fillable = [
        'materi_id',
        'kelas_id',
    ];


    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }}
