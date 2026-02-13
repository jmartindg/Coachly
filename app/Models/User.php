<?php

namespace App\Models;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Enums\Sex;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'client_status',
        'age',
        'sex',
        'height',
        'weight',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'client_status' => ClientStatus::class,
            'sex' => Sex::class,
        ];
    }

    public function isCoach(): bool
    {
        return $this->role === Role::Coach;
    }

    public function isClient(): bool
    {
        return $this->role === Role::Client;
    }

    public function isLead(): bool
    {
        return $this->role === Role::Client && $this->client_status === ClientStatus::Lead;
    }

    public function isApplied(): bool
    {
        return $this->role === Role::Client && $this->client_status === ClientStatus::Applied;
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
