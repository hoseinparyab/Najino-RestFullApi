<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::created(function ($permission) {
            Role::whereName('admin')->first()->permissions()->attach([$permission->id]);
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
}

