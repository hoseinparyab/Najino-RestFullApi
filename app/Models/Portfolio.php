<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover_image',
        'images',
        'title',
        'description',
        'site_address',
        'our_job'
    ];

    protected $casts = [
        'images' => 'array'
    ];//
}
