<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'name',
        'position',
        'role_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'employee_id', 'employee_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class, 'admin_id', 'employee_id');
    }
}