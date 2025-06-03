<?php

namespace App\Models;

use App\Base\traits\HasRules;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, HasRules, Sluggable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'image',
        'view',
    ];

    public function scopeSearch($query, $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true, // اسلاگ را هنگام آپدیت خودکار تغییر دهد

            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static $rules = [
        'title' => ['required', 'string', 'min:1', 'max:255'],
        'category_id' => ['required', 'exists:categories,id'],
        'body' => ['required', 'string'],
        'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    ];
}
