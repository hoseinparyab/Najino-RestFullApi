<?php

namespace App\Models;

use App\Base\traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, HasRules, SoftDeletes;

    protected $fillable = ['name', 'display_name'];

    protected static $rules = [
        'name' => 'required|string|unique:roles,name',
        'display_name' => 'required|string',
        'permissions' => 'required|array',
        'permissions.*' => 'exists:permissions,id',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Create a role if it doesn't exist
     */
    public static function createIfNotExists(string $name, string $displayName): Role
    {
        return self::firstOrCreate(
            ['name' => $name],
            ['display_name' => $displayName]
        );
    }
}
