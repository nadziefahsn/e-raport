<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CapaianPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'capaians';

    protected $fillable = [
        'capaian_perkembangan',
    ];

    public function indikators(): HasMany
    {
        return $this->hasMany(Indikator::class, 'capaian_perkembangan_id'); 
    }
}