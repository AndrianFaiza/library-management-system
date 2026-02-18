<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'jurusan',
        'no_hp',
        'email',
    ];
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
