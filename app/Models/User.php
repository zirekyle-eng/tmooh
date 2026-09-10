<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'full_name', 'email', 'phone', 'password_hash', 'role',
        'country', 'city', 'market_id', 'status',
    ];

    protected $hidden = ['password_hash', 'password_ciphertext'];

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function getNameAttribute(): string
    {
        return (string) $this->full_name;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'market_id' => 'integer',
        ];
    }
}
