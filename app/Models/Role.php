<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = ['role_name', 'description', 'is_active'];

    // 1 to 1 relationship with User
    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
