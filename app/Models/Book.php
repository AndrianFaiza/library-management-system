<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $table = 'book';
    protected $fillable = [
        'isbn',
        'judul_buku',
        'penerbit',
        'tahun_terbit',
        'pengarang',
        'rak_id',
        'jumlah',
    ];

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
    public function detail(): HasMany
    {
        return $this->hasMany(Detail::class);
    }
}
