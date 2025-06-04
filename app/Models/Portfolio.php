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

    // Remove the JSON cast as we're storing images as a string
    // protected $casts = [
    //     'images' => 'array'
    // ];

    // Remove the accessor as we're storing images as a simple string
    // public function getImagesAttribute($value)
    // {
    //     return json_decode($value);
    // }


    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = $value;
    }

    public function getCoverImageAttribute($value)
    {
        return $value;
    }

    public function setCoverImageAttribute($value)
    {
        $this->attributes['cover_image'] = $value;
    }

}
