<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Model as BaseModel;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable, Authorizable;

    const ROLES = [
        'admin' => 'ADMIN',
        'customer' => 'CUSTOMER',
        'author' => 'AUTHOR'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'createdAt' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'id', 'updatedAt'
    ];

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uniqueUserId';
    }
}
