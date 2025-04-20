<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // Define the primary key for the Role model (if it's not the default 'id')
    protected $primaryKey = 'role_id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'position', // Role name/position (e.g., 'admin', 'user', etc.)
    ];

    // Define the relationship with the User model (One-to-Many)
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');  // Define the foreign key for the relationship
    }
}
