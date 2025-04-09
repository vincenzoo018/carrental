<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'admin',
        'customer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'role_id', 'role_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'role_id', 'role_id');
    }
}