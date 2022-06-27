<?php

namespace App\Models\User;

use App\Casts\EmailCast;
use App\ValueObjects\Email;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string|null name
 * @property Email|null email
 * @property string|null remember_token
 * @property Carbon|null email_verified_at
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email' => EmailCast::class,
        'email_verified_at' => 'datetime',
    ];
}
