<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    //
}
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalans';

    protected $fillable = [
        'capaian_hafalan',
    ];

    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class, 'capaian_hafalan_id'); 
    }}
>>>>>>> 0e508e9d92c8a29950cbf2643a6f271e7cefeb76
