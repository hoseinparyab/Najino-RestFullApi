<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Permission extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'display_name',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
