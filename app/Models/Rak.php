<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rak extends Model
{
    protected $table = 'rak';
    protected $fillable = [
        'nama_rak',
        'lokasi',
        'kapasitas',
    ];

}
