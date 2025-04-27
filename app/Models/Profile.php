<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'phone',
        'address',
        'birth_date',
        'gender',
        'website',
        'social_links'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'social_links' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
