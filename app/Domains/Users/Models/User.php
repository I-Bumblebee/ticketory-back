<?php

namespace App\Domains\Users\Models;

use App\Domains\Tickets\Models\Ticket;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return new UserFactory;
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->name $this->lastname"
        );
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
