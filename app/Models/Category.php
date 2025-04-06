<?php
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Base\traits\HasRules;
class Category extends Model
{
    use Sluggable, HasFactory, SoftDeletes,HasRules;
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'   => 'name',
                'onUpdate' => true, // اسلاگ را هنگام آپدیت خودکار تغییر دهد

            ],
        ];
    }

    public function parentCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault(['title' => 'دسته بندی اصلی']);
    }

    public function childCategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public static function getCategories(): array
    {
        $array      = [];
        $categories = self::query()->with('childCategory')->where('parent_id', 0)->get();
        foreach ($categories as $category1) {
            $array[$category1->id] = $category1->name;
            foreach ($category1->childCategory as $category2) {
                $array[$category2->id] = '-' . $category2->name;
                foreach ($category2->childCategory as $category3) {
                    $array[$category3->id] = '--' . $category3->name;
                }
            }
        }
        return $array;

    }

    protected static function boot(): void
    {
        parent::boot();
        self::deleting(function ($category) {
            foreach ($category->childCategory()->get() as $child) {
                $child->delete();

            }
        });
    }

    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Article::class);
    }
    public function articleCount($category_id): int
    {
        return Article::query()->where('category_id', $category_id)->count();
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'parent_id' => ['nullable', 'integer'],
        ];
    }
}
