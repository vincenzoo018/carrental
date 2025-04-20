<?php

// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Custom primary key for the Employee model
    protected $primaryKey = 'employee_id';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'position',
        'role_id',
    ];

    // Define the relationship to the Role model (a user has one role)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Define the relationship to the Service model (a user can have many services)
    public function services()
    {
        return $this->hasMany(Service::class, 'employee_id');
    }

    // Define the relationship to the Sales model (a user can have many sales)
    public function sales()
    {
        return $this->hasMany(Sales::class, 'employee_id');
    }
}
