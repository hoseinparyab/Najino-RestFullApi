<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'display_name'];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($permission) {
            // Find admin role - if it doesn't exist yet (during seeding) this won't cause errors
            $adminRole = Role::whereName('admin')->first();
            if ($adminRole) {
                $adminRole->permissions()->attach([$permission->id]);
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Create a permission if it doesn't exist
     */
    public static function createIfNotExists(string $name, string $displayName): Permission
    {
        return self::firstOrCreate(
            ['name' => $name],
            ['display_name' => $displayName]
        );
    }
}
