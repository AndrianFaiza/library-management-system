<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auth extends Authenticatable
{
    use Notifiable;

    protected $table = 'auth';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pengembalian(): HasMany
    {
        return $this->hasMany(Pengembalian::class);
    }
}
