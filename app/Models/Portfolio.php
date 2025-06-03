<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

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
    ];

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getCoverImageAttribute($value)
    {
        return json_decode($value);
    }

    public function setCoverImageAttribute($value)
    {
        $this->attributes['cover_image'] = json_encode($value);
    }

}
