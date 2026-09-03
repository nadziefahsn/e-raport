<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karakter extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'karakter',
    ];
}
