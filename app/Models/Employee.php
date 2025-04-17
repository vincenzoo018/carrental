<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'name',
        'position',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'employee_id');
    }

    public function sales()
    {
        return $this->hasMany(Sales::class, 'employee_id');
    }
}
