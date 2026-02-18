<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $fillable = [
        'peminjaman_id',
        'tanggal_dikembalikan',
        'denda',
        'user_id',
    ];

    protected $casts = [
        'tanggal_dikembalikan' => 'date',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id' );
    }
}
