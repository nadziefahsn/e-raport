<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'capaians';

    protected $fillable = [
        'capaian_perkembangan',
    ];
}