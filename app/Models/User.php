<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Base\traits\HasRules;
use Laravel\Sanctum\HasApiTokens;
use Amirhosseinabd\LaravelEasySearch\Eloquent\Traits\Searchable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRules, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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
        ];
    }
    protected static $rules = [
        'first_name' => ['required', 'string', 'min:1', 'max:255'],
        'last_name' => ['required', 'string', 'min:1', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'max:255'],
    ];
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
