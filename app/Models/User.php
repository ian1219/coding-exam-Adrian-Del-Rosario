<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['full_name', 'email', 'password', 'role_id'];
    protected $hidden   = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
