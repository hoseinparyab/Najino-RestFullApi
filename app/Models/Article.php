<?php
namespace App\Models;

use App\Base\traits\HasRules;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasRules;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'image',
        'view',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => 'title',
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
    protected static $rules = [
        'title'       => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'body'        => 'required|string',
        'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

}
