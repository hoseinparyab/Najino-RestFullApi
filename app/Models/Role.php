<?php
namespace App\Models;

use App\Base\traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasRules;

    protected $guarded = [];

    protected static $rules = [
        'name'          => 'required|string|unique:roles,name',
        'display_name'  => 'required|string',
        'permissions'   => 'required|array',
        'permissions.*' => 'exists:permissions,id',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
